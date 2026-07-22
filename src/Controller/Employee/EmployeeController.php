<?php

namespace App\Controller\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OrderRepository;

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
 
}