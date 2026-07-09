<?php

namespace App\Controller\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Entity\OrderContact;
use App\Entity\OrderStatusHistory;
use App\Form\UpdateOrderStatusType;
use App\Form\CancelOrderType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

#[Route('/espace-employe', name: 'employee_')]
class OrderController extends AbstractController
{
    #[Route('/commande/{id}/statut', name: 'update_order_status', methods: ['GET', 'POST'])]
    public function updateOrderStatus(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('Commande introuvable.');
        }

        $form = $this->createForm(UpdateOrderStatusType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \App\Entity\User $employee */
            $employee = $this->getUser();
            $newStatus = $form->get('status')->getData();

            $history = new OrderStatusHistory();
            $history->setOrderRef($order);
            $history->setChangedBy($employee);
            $history->setStatus($newStatus);
            $history->setChangedAt(new \DateTimeImmutable());

            $order->setStatus($newStatus);

            $entityManager->persist($history);
            $entityManager->flush();

            if ($newStatus === 'WAITING_MATERIAL') {
                $order->setHasBorrowedMaterial(true);
                
                $email = (new TemplatedEmail())
                    ->to($order->getEmail())
                    ->subject('Retour de matériel | Vite & Gourmand')
                    ->htmlTemplate('emails/waiting_material.html.twig')
                    ->context(['order' => $order]);

                $mailer->send($email);
            }

            if ($newStatus === 'COMPLETED') {
                $email = (new TemplatedEmail())
                    ->to($order->getEmail())
                    ->subject('Votre commande est terminée — Donnez votre avis !')
                    ->htmlTemplate('emails/order_completed.html.twig')
                    ->context([ 'order' => $order ]);

                $mailer->send($email);
            }

            $this->addFlash('success', 'Statut mis à jour avec succès.');
            return $this->redirectToRoute('employee_dashboard');

        }

        return $this->render('employee/order/update_order_status.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
        ]);
    }

    #[Route('/commande/{id}/annuler', name: 'cancel_order', methods: ['GET', 'POST'])]
    public function cancelOrder(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('Commande introuvable.');
        }

        $form = $this->createForm(CancelOrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \App\Entity\User $employee */
            $employee = $this->getUser();

            $contact = new OrderContact();
            $contact->setCustomerOrder($order);
            $contact->setContactedBy($employee);
            $contact->setContactMode($form->get('contactMode')->getData());
            $contact->setReason($form->get('reason')->getData());
            $contact->setContactedAt(new \DateTimeImmutable());

            $history = new OrderStatusHistory();
            $history->setOrderRef($order);
            $history->setChangedBy($employee);
            $history->setStatus('CANCELLED');
            $history->setChangedAt(new \DateTimeImmutable());

            $order->setStatus('CANCELLED');

            $entityManager->persist($contact);
            $entityManager->persist($history);
            $entityManager->flush();

            $this->addFlash('success', 'Commande annulée avec succès.');
            return $this->redirectToRoute('employee_dashboard');

        }

        return $this->render('employee/order/cancel_order.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
    }
}