<?php

namespace App\Controller\Public\Menu;

use App\Repository\MenuRepository;
use App\Repository\RegimeRepository;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MenuController extends AbstractController
{
    public function __construct(
        private MenuRepository $menuRepository,
        private ThemeRepository $themeRepository,
        private RegimeRepository $regimeRepository,
    ){}

    #[Route('/menus', name: 'menu_index', methods: ['GET'])]
    public function index(): Response
    {
        $menus = $this->menuRepository->findAllForGlobalView();
        $themes = $this->themeRepository->findAll();
        $regimes = $this->regimeRepository->findAll();

        return $this->render('public/menu/menus.html.twig', [
            'menus' => $menus,
            'themes' => $themes,
            'regimes' => $regimes
        ]);
    }

    #[Route('/menus/{id}', name: 'menu_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        $menu = $this->menuRepository->findOneForDetail($id);

        if(!$menu){
            throw $this->createNotFoundException('Ce menu n\'existe pas.');
        }

        return $this->render('public/menu/show.html.twig', [
            'menu' => $menu
        ]);
    }
}
