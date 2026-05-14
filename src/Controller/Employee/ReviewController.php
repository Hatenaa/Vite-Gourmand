<?php

namespace App\Controller\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Review;
use App\Repository\ReviewRepository;

#[Route('/espace-employe/avis', name: 'employee_review_')]
class ReviewController extends AbstractController
{
    #[Route('', name: 'list')]
    public function reviews(ReviewRepository $reviewRepository): Response
    {
        $reviews = $reviewRepository->findBy(['status' => 'PENDING']);

        return $this->render('employee/reviews.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    
    #[Route('/{id}/{action}', name: 'action', methods: ['POST'], requirements: ['action' => 'validate|reject'])]
    public function reviewAction(int $id, string $action, EntityManagerInterface $entityManager): Response
    {
        $review = $entityManager->getRepository(Review::class)->find($id);

        if (!$review) {
            throw $this->createNotFoundException('Avis introuvable.');
        }

        $review->setStatus($action === 'validate' ? 'VALIDATED' : 'REJECTED');
        $review->setReviewAt(new \DateTimeImmutable());
        $entityManager->flush();

        $this->addFlash('success', 'Avis mis à jour.');
        return $this->redirectToRoute('employee_review_list');
    }
}