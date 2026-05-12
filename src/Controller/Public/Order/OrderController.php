<?php

namespace App\Controller\Public\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Order;
use App\Entity\Menu;
use App\Form\OrderType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderController extends AbstractController
{
    #[Route('/commande/nouvelle/{menuId}', name: 'order_new', requirements: ['menuId' => '\d+'], defaults: ['menuId' => null])]
    public function new(
        ?int $menuId,
        Request $request,
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        HttpClientInterface $httpClient
    ): Response {

        /** @var  \App\Entity\User $user */

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez vous connecter pour commander un menu.');
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
                    return $this->redirectToRoute('menus');
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
                    return $this->redirectToRoute('menus');
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

            // Calculons la distance entre Bordeaux et le point de livraison via OpenStreetMap
            $coords = $this->geocode($order->getAddress(), $order->getCity(), $httpClient);
            if (!$coords) {
                $form->addError(new FormError('Adress introuvable. Veuillez vérifier votre adresse et ville.'));
                return $this->render('public/order/new.html.twig', [

                    'form' => $form->createView(),
                    'order' => $order,
                    'preSelectedMenu' => $menu
                ]);
            }

            $bordeauxLat = 44.837789;
            $bordeauxLon = -0.57918;
            $distance = $this->haversineDistance($coords['lat'], $coords['lon'], $bordeauxLat, $bordeauxLon);
            $order->setDistanceKm((string) $distance);

            $menuPrice = (float) $menu->getBasePrice() * $order->getPeopleCount();


            // Maintenant, calculons les prix...
            $menuPrice = (float) $menu->getBasePrice() * $order->getPeopleCount();
            $cityNormalized = mb_strtolower(trim($order->getCity()));

            if ($cityNormalized !== 'bordeaux') {
                $deliveryPrice = 5 + (0.59 * (float) $order->getDistanceKm());
            } else {
                $deliveryPrice = 0; // La livraison à Bordeaux est offerte
            }

            $discount = 0;
            if ($order->getPeopleCount() >= $menu->getMinPeople() + 5) {
                $discount = $menuPrice * 0.10;
            }

            $totalPrice = $menuPrice - $discount + $deliveryPrice;

            $order->setMenuPrice((string) $menuPrice);
            $order->setDeliveryPrice((string) $deliveryPrice);
            $order->setDiscount((string) $discount);
            $order->setTotalPrice((string) $totalPrice);

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

    #[Route('/commande/finalisation', name: 'order_finalize')]
    public function finalize(
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $orderData = $session->get('order_data');
        if (!$orderData) {
            $this->addFlash('error', 'Aucune commande n\'est en cours.');
            return $this->redirectToRoute('order_new');
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

        // On vas reverifié si le menu existe par précaution.
        if (!$menu) {
            $this->addFlash('error', 'Le menu est introuvable.');
            return $this->redirectToRoute('order_new');
        }
        $order->setMenu($menu);

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté.');
            return $this->redirectToRoute('login');
        }

        $order->setUser($user);

        $order->setCreatedAt(new \DateTimeImmutable());
        $order->setStatus('PENDING');
        $order->setHasBorrowedMaterial(false);

        $entityManager->persist($order);
        $entityManager->flush();

        $email = (new TemplatedEmail())
            ->from('noreply@vite-et-gourmand.fr')
            ->to($order->getEmail())
            ->subject('Confirmation de votre commande')
            ->htmlTemplate('emails/order_confirmation.html.twig')
            ->context([
                'order' => $order,
                'menu' => $menu
            ]);

        $mailer->send($email);

        $session->remove('order_data'); // Vu que le tableau ne sert plus à rien après traitement, on le supprime.
        $this->addFlash('success', 'Commande confirmée avec succès ! Vous recevrez un email de confirmation.');

        return $this->redirectToRoute('home');
    }

    private function geocode(string $address, string $city, HttpClientInterface $httpClient): ?array
    {
        $query = urlencode($address . ', ' . $city . ', France');
        $url = "https://nominatim.openstreetmap.org/search?q=$query&format=json&limit=1";

        try {
            $response = $httpClient->request('GET', $url, [
                'headers' => [
                    'User-Agent' => 'Vite-et-Gourmand/1.0 (contact@vite-et-gourmand.fr)'
                ]
            ]);

            $data = $response->toArray();
            if (empty($data)) {
                return null;
            }
            return [
                'lat' => (float) $data[0]['lat'],
                'lon' => (float) $data[0]['lon']
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    private function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // (km)

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;

    }
}