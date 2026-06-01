<?php

namespace App\Controller\Api;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ApiMenuController extends AbstractController
{

    public function __construct(
        private MenuRepository $menuRepository
    ) {
    }

    #[Route('/api/menus', name: 'api_menus', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'minPrice' => $request->query->get('minPrice'),
            'maxPrice' => $request->query->get('maxPrice'),
            'theme' => $request->query->get('theme'),
            'regime' => $request->query->get('regime'),
            'minPeople' => $request->query->get('minPeople'),
        ];

        $menus = $this->menuRepository->findFilteredMenus($filters);

        $data = [];

        foreach ($menus as $menu) {
            $data[] = $this->formatMenu($menu);
        }

        return $this->json($data);
    }

    private function formatMenu(Menu $menu): array
    {
        $mainImage = null;

        if (!$menu->getImages()->isEmpty()) {
            $image = $menu->getImages()->first();

            $mainImage = [
                'path' => $image->getPath(),
                'alt' => $image->getAlt(),
            ];
        }

        return [
            'id' => $menu->getId(),
            'title' => $menu->getTitle(),
            'description' => $menu->getDescription(),
            'minPeople' => $menu->getMinPeople(),
            'basePrice' => $menu->getBasePrice(),
            'stock' => $menu->getStock(),
            'image' => $mainImage,
            'theme' => $menu->getTheme() ? [
                'id' => $menu->getTheme()->getId(),
                'label' => $menu->getTheme()->getLabel(),
            ] : null,
        ];

    }
}
