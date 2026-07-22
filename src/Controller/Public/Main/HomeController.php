<?php

namespace App\Controller\Public\Main;

use App\Repository\ReviewRepository;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

        public function __construct(
            private ReviewRepository $reviewRepository,
            private ThemeRepository $themeRepository
        ) {}

        #[Route('/', name: 'home')]
        public function index(): Response
        {

            $reviews = $this->reviewRepository->findValidateReviews();
            $themes = $this->themeRepository->findThemesWithMenus();

            return $this->render('public/main/home.html.twig', [
                'reviews' => $reviews,
                'themes' => $themes,
            ]);
    }
}