<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EMPLOYEE')]
class ApiOrderController extends AbstractController
{
    public function __construct(private OrderRepository $orderRepository)
    {

    }

    #[Route('/api/orders', name: 'api_orders', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $status = $request->query->get('status');
        $email = $request->query->get('email');

        $orders = $this->orderRepository->findByFilters($status, $email);

        return $this->json(array_map(fn(Order $order) => $this->formatOrder($order), $orders));
    }

    private function formatOrder(Order $order): array
    {

        $menu = $order->getMenu();
        $menuImages = [];

        if ($menu && $menu->getImages()){
            foreach ($menu->getImages() as $image) {
                $menuImages[] = [
                    'path' => $image->getPath(),
                    'alt' => $image->getAlt() ?? $menu->getTitle(),
                ];
            }
        }

        return [
            'id' => $order->getId(),
            'firstName' => $order->getFirstName(),
            'lastName' => $order->getLastName(),
            'email' => $order->getEmail(),
            'status' => $order->getStatus(),
            'deliveryDate' => $order->getDeliveryDate()?->format('d/m/Y'),
            'menuTitle' => $order->getMenu()?->getTitle(),
            'menuImages' => $menuImages,
            'peopleCount' => $order->getPeopleCount(),
            'totalPrice' => $order->getTotalPrice(),
            'manageUrl' => $this->generateUrl('employee_update_order_status', [
                'id' => $order->getId()
            ]),
        ];
    }
}