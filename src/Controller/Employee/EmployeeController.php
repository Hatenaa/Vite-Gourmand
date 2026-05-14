<?php

namespace App\Controller\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Entity\OrderContact;
use App\Entity\OrderStatusHistory;
use App\Form\UpdateOrderStatusType;

#[Route('/espace-employe', name: 'employee_')]
class EmployeeController extends AbstractController
{
    #[Route('', name: 'dashboard')]
    public function dashboard(Request $request, OrderRepository $orderRepository): Response
    {
        $status = $request->query->get('status');
        $email = $request->query->get('email');

        $orders = $orderRepository->findByFilters($status, $email);

        return $this->render('employee/dashboard.html.twig', [
            'orders' => $orders,
            'currentStatus' => $status,
            'currentEmail' => $email,
        ]);
    }

    #[Route('/commande/{id}/statut', name: 'update_order_status', methods: ['GET', 'POST'])]
    public function updateOrderStatus(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('Commande introuvable.');
        }

        $form = $this->createForm(UpdateOrderStatusType::class);
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
            $history->setStatus($form->get('status')->getData());
            $history->setChangedAt(new \DateTimeImmutable());

            $order->setStatus($form->get('status')->getData());

            $entityManager->persist($contact);
            $entityManager->persist($history);
            $entityManager->flush();

            $this->addFlash('success', 'Statut mis à jour avec succès.');
            return $this->redirectToRoute('employee_dashboard');

        }

        return $this->render('employee/update_order_status.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
        ]);
    }
}