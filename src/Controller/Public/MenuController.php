<?php

namespace App\Controller\Public;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MenuController extends AbstractController
{
    public function __construct(
        private MenuRepository $menuRepository
    ) {

    }
    #[Route('/menus', name: 'menus', methods: ['GET'])]
    public function index(): Response
    {
        $menus = $this->menuRepository->findAllForGlobalView();

        return $this->render('public/menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }
}
