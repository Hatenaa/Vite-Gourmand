<?php

namespace App\Controller\Admin;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/espace-admin/stats', name: 'admin_stats_')]
class StatsController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findAll();

        return $this->render('admin/stats.html.twig', [
            'menus' => $menus
        ]);
    }
}