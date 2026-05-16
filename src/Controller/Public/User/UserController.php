<?php

namespace App\Controller\Public\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Entity\Review;
use App\Form\EditOrderType;
use App\Form\ReviewType;
use App\Service\OrderPricingService;
use Symfony\Component\Form\FormError;

#[Route('/mon-espace', name: 'user_')]
class UserController extends AbstractController
{
    public function __construct(private OrderPricingService $pricingService) {}

    #[Route('', name:'dashboard')]
    public function dashboard(): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $orders = $user->getOrders();

        return $this->render('public/user/dashboard.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/profil', name: 'edit_profile')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('user_dashboard');
        }

        return $this->render('public/user/edit_profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commande/{id}', name:'order_detail')]
    public function orderDetail(int $id, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $order = $entityManager->getRepository(Order::class)->find($id);

        if(!$order || $order->getUser() !== $user){
            throw $this->createNotFoundException('Commande introuvable.');
        }

        return $this->render('public/user/order_detail.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/commande/{id}/modifier', name: 'edit_order')]
    public function editOrder(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $order = $entityManager->getRepository(Order::class)->find($id);

        if(!$order || $order->getUser() !== $user){
            throw $this->createNotFoundException('Commande introuvable.');
        }

        if($order->getStatus() !== 'PENDING'){
            $this->addFlash('error', 'Cette commande ne peut plus être modifiée.');
            return $this->redirectToRoute('user_order_detail', ['id' => $id]);
        }

        $form = $this->createForm(EditOrderType::class, $order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            if ($order->getPeopleCount() < $order->getMenu()->getMinPeople()){
                $form->get('peopleCount')->addError(
                    new FormError('Le minimum pour ce menu est ' . $order->getMenu()->getMinPeople() . ' personnes.')
                );
                return $this->render('public/user/edit_order.html.twig', [
                    'form' => $form->createView(),
                    'order' => $order
                ]);
            }

            $prices = $this->pricingService->calculatePrices(
                $order->getMenu(),
                $order->getPeopleCount(),
                $order->getAddress(),
                $order->getCity()
            );

            if(!$prices) {
                $form->addError(new FormError('Adresse introuvable. Veuillez vérifier votre adresse.'));
                return $this->render('public/user/edit_order.html.twig', [
                    'form' => $form->createView(),
                    'order' => $order,
                ]);
            }

            $order->setDistanceKm($prices['distanceKm']);
            $order->setMenuPrice($prices['menuPrice']);
            $order->setDeliveryPrice($prices['deliveryPrice']);
            $order->setDiscount($prices['discount']);
            $order->setTotalPrice($prices['totalPrice']);

            $entityManager->flush();
            $this->addFlash('success', 'Commande modifiée avec succès.');
            return $this->redirectToRoute('user_order_detail', ['id' => $id]);
        }

        return $this->render('public/user/edit_order.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
        ]);
    }

    #[Route('/commande/{id}/annuler', name: 'cancel_order', methods: ['POST'])]
    public function cancelOrder(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $order = $entityManager->getRepository(Order::class)->find($id);

        if(!$order || $order->getUser() !== $user){
            throw $this->createNotFoundException('Commande introuvable.');
        }

        if($order->getStatus() !== 'PENDING'){
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('user_dashboard');
        }

        if(!$this->isCsrfTokenValid('cancel_order_' . $id, $request->request->get('_token'))){
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('user_dashboard');
        }

        $order->setStatus('CANCELLED');
        $entityManager->flush();

        $this->addFlash('success', 'Commande annulée avec succès.');
        return $this->redirectToRoute('user_dashboard');
    }

    #[Route('/commande/{id}/avis', name: 'submit_review', methods: ['GET', 'POST'])]
    public function submitReview(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $order = $entityManager->getRepository(Order::class)->find($id);

        if(!$order || $order->getUser() !== $user){
            throw $this->createNotFoundException('Commande introuvable.');
        }

        if($order->getStatus() !== 'COMPLETED'){
            $this->addFlash('error', 'Vous ne pouvez pas encore laisser un avis.');
            return $this->redirectToRoute('user_order_detail', ['id' => $id]);
        }

        if($order->getReview() !== null){
            $this->addFlash('error', 'Vous avez déjà laissé un avis pour cette commande.');
            return $this->redirectToRoute('user_order_detail', ['id' => $id]);
        }

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $review->setUser($user);
            $review->setCustomerOrder($order);
            $review->setStatus('PENDING');
            $review->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash('success', 'Votre avis a bien été envoyé. Il sera visible après validation.');
            return $this->redirectToRoute('user_order_detail', ['id' => $id]);
        }

        return $this->render('public/user/submit_review.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
        
    }
}