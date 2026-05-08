<?php

namespace App\Controller\Public\Main;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

        public function __construct(
            private ReviewRepository $reviewRepository
        ) {
        }

        #[Route('/', name: 'home')]
        public function index(): Response
        {

            $reviews = $this->reviewRepository->findValidateReviews();

            return $this->render('public/main/home.html.twig', [
                'reviews' => $reviews,
            ]);
    }
}