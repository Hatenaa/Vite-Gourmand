<?php

namespace App\Controller\Public\Order;

use App\Service\OrderPricingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Order;
use App\Entity\Menu;
use App\Form\OrderType;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Document\OrderStat;
use Doctrine\ODM\MongoDB\DocumentManager;

class OrderController extends AbstractController
{
    use TargetPathTrait;

    public function __construct(private OrderPricingService $pricingService, private DocumentManager $documentManager)
    {
    }

    #[Route('/commande/nouvelle/{menuId}', name: 'order_new', requirements: ['menuId' => '\d+'], defaults: ['menuId' => null])]
    public function new(
        ?int $menuId,
        Request $request,
        EntityManagerInterface $entityManager,
        SessionInterface $session,
    ): Response {

        /** @var  \App\Entity\User $user */

        $user = $this->getUser();
        if (!$user) {

            $this->saveTargetPath($request->getSession(), 'main', $request->getUri());
            $this->addFlash('danger', 'Vous devez vous connecter pour commander un menu.');
            return $this->redirectToRoute('login');
        }

        $orderData = $session->get('order_data');

        if ($orderData && $menuId && $orderData['menuId'] != $menuId) {
            $session->remove('order_data');
            $orderData = null;
        }

        if ($orderData) {

            // Si l'utilisateur viens d'une page de confirmation, alors on pré-remplie...
            $order = new Order();

            $order->setFirstName($orderData['firstName']);
            $order->setLastName($orderData['lastName']);
            $order->setEmail($orderData['email']);
            $order->setPhone($orderData['phone']);
            $order->setAddress($orderData['address']);
            $order->setCity($orderData['city']);
            $order->setDeliveryDate(new \DateTimeImmutable($orderData['deliveryDate']));
            $order->setDeliveryTime(new \DateTimeImmutable($orderData['deliveryTime']));
            $order->setPeopleCount($orderData['peopleCount']);
            $order->setDistanceKm($orderData['distanceKm']);

            $menu = $entityManager->getRepository(Menu::class)->find($orderData['menuId']);

            if ($menu && $menu->isActive()) {
                $order->setMenu($menu);
                $preSelectedMenu = $menu;
            } else {
                $this->addFlash('warning', 'Le menu précédemment choisi n\'est plus disponible. ');
                $preSelectedMenu = null;
            }

        } else {

            $order = new Order();
            $order->setFirstName($user->getFirstName());
            $order->setLastName($user->getLastName());
            $order->setEmail($user->getEmail());
            $order->setPhone($user->getPhone());

            if ($menuId) {

                $menu = $entityManager->getRepository(Menu::class)->find($menuId);
                if (!$menu || !$menu->isActive()) {

                    $this->addFlash('error', 'Menu indisponible.');
                    return $this->redirectToRoute('menu_index');
                }
                $order->setMenu($menu);
                $preSelectedMenu = $menu;

            } else {
                $preSelectedMenu = null;
            }

        }
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $order = $form->getData();

            if ($request->request->has('selected_menu_id')) {
                $menuId = $request->request->get('selected_menu_id');
                $menu = $entityManager->getRepository(Menu::class)->find($menuId);

                if ($menu && $menu->isActive()) {
                    $order->setMenu($menu);
                } else {
                    $this->addFlash('error', 'Menu indisponible.');
                    return $this->redirectToRoute('menu_index');
                }
            }

            $menu = $order->getMenu();

            if (!$menu) {
                $this->addFlash('error', 'Veuillez sélectionner un menu.');
                return $this->redirectToRoute('order_new');
            }

            if ($order->getPeopleCount() < $menu->getMinPeople()) {
                $form->get('peopleCount')->addError(
                    new FormError(
                        'Le nombre de personnes pour ce menu est de ' . $menu->getMinPeople() . '.'
                    )
                );

                return $this->render('public/order/new.html.twig', [
                    'form' => $form->createView(),
                    'order' => $order,
                    'preSelectedMenu' => $menu,
                ]);
            }

            $prices = $this->pricingService->calculatePrices(
                $menu,
                $order->getPeopleCount(),
                $order->getAddress(),
                $order->getCity()
            );

            if (!$prices) {
                $form->addError(new FormError('Adresse introuvable. Veuillez vérifier votre adresse et ville.'));
                return $this->render('public/order/new.html.twig', [
                    'form' => $form->createView(),
                    'order' => $order,
                    'preSelectedMenu' => $menu
                ]);
            }

            $order->setDistanceKm($prices['distanceKm']);
            $order->setMenuPrice($prices['menuPrice']);
            $order->setDeliveryPrice($prices['deliveryPrice']);
            $order->setDiscount($prices['discount']);
            $order->setTotalPrice($prices['totalPrice']);

            // Et stockons les informations dans la session
            $orderData = [
                'firstName' => $order->getFirstName(),
                'lastName' => $order->getLastName(),
                'email' => $order->getEmail(),
                'phone' => $order->getPhone(),
                'address' => $order->getAddress(),
                'city' => $order->getCity(),
                'deliveryDate' => $order->getDeliveryDate()->format('Y-m-d'),
                'deliveryTime' => $order->getDeliveryTime()->format('H:i'),
                'peopleCount' => $order->getPeopleCount(),
                'distanceKm' => $order->getDistanceKm(),
                'menuId' => $menu->getId(),
                'menuTitle' => $menu->getTitle(),
                'menuPrice' => $order->getMenuPrice(),
                'deliveryPrice' => $order->getDeliveryPrice(),
                'discount' => $order->getDiscount(),
                'totalPrice' => $order->getTotalPrice()
            ];
            $session->set('order_data', $orderData);

            return $this->redirectToRoute('order_confirm');

        }

        return $this->render('public/order/new.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'preSelectedMenu' => $preSelectedMenu
        ]);

    }

    #[Route('/commande/confirmation', name: 'order_confirm')]
    public function confirm(SessionInterface $session): Response
    {
        $orderData = $session->get('order_data');

        if (!$orderData) {
            $this->addFlash('error', 'Aucune commande en cours. Veuillez d\'abord remplir le formulaire.');
            return $this->redirectToRoute('order_new');
        }

        return $this->render('public/order/confirm.html.twig', [
            'orderData' => $orderData
        ]);
    }

    #[Route('/commande/finalisation', name: 'order_finalize', methods: ['POST'])]
    public function finalize(
        SessionInterface $session,
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {

        $orderData = $session->get('order_data');
        if (!$orderData) {
            $this->addFlash('error', 'Aucune commande n\'est en cours.');
            return $this->redirectToRoute('order_new');
        }

        if (!$this->isCsrfTokenValid('order_finalize', $request->request->get('_token'))) {
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('order_confirm');
        }

        $order = new Order();

        $order->setFirstName($orderData['firstName']);
        $order->setLastName($orderData['lastName']);
        $order->setEmail($orderData['email']);
        $order->setPhone($orderData['phone']);
        $order->setAddress($orderData['address']);
        $order->setCity($orderData['city']);
        $order->setDeliveryDate(new \DateTimeImmutable($orderData['deliveryDate']));
        $order->setDeliveryTime(new \DateTimeImmutable($orderData['deliveryTime']));
        $order->setPeopleCount($orderData['peopleCount']);
        $order->setDistanceKm($orderData['distanceKm']);
        $order->setMenuPrice($orderData['menuPrice']);
        $order->setDeliveryPrice($orderData['deliveryPrice']);
        $order->setDiscount($orderData['discount']);
        $order->setTotalPrice($orderData['totalPrice']);

        $menu = $entityManager->getRepository(Menu::class)->find($orderData['menuId']);

        // On va revérifier si le menu existe par précaution.
        if (!$menu) {
            $this->addFlash('danger', 'Le menu est introuvable.');
            return $this->redirectToRoute('order_new');
        }

        $availableStock = $menu->getStock();

        if ($availableStock < $orderData['peopleCount']) {
            $this->addFlash('danger', sprintf(
                'Stock insuffisant pour ce menu. Il reste %d %s.',
                $availableStock,
                $availableStock > 1 ? 'portions disponibles' : 'portion disponible'
            ));
            return $this->redirectToRoute('menu_index');
        }

        $menu->setStock($availableStock - $orderData['peopleCount']);

        $order->setMenu($menu);

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté.');
            return $this->redirectToRoute('login');
        }

        $order->setUser($user);

        $order->setCreatedAt(new \DateTimeImmutable());
        $order->setStatus('PENDING');
        $order->setHasBorrowedMaterial(false);

        $entityManager->persist($order);
        $entityManager->flush();

        $month = new \DateTimeImmutable($order->getDeliveryDate()->format('Y-m') . '-01');

        $stat = $this->documentManager
            ->getRepository(OrderStat::class)
            ->findOneBy(['menuTitle' => $menu->getTitle(), 'month' => $month]);

        if ($stat) {
            $stat->setOrderCount($stat->getOrderCount() + $order->getPeopleCount());
            $stat->setTotalRevenue($stat->getTotalRevenue() + $order->getMenuPrice());
        } else {

            $stat = new OrderStat();
            $stat->setMenuTitle($menu->getTitle());
            $stat->setMonth($month);
            $stat->setOrderCount($order->getPeopleCount());
            $stat->setTotalRevenue($order->getMenuPrice());
            $this->documentManager->persist($stat);
        }

        $this->documentManager->flush();

        // Maintenant, mettons à jour nos statistiques MongoDB...

        $email = (new TemplatedEmail())
            ->to($order->getEmail())
            ->subject('Confirmation de votre commande')
            ->htmlTemplate('emails/order_confirmation.html.twig')
            ->context([
                'order' => $order,
                'menu' => $menu
            ]);

        $mailer->send($email);

        $session->remove('order_data'); // Vu que le tableau ne sert plus à rien après traitement, on le supprime.
        $this->addFlash('success', 'Commande confirmée avec succès ! Vous recevrez un email récapitulatif de votre achat.');

        return $this->redirectToRoute('home');
    }
}