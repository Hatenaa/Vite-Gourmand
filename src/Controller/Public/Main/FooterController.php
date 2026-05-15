<?php

namespace App\Controller\Public\Main;

use App\Repository\OpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FooterController extends AbstractController
{
    #[Route('/_footer', name: 'footer')]
    public function index(OpeningHoursRepository $openingHoursRepository): Response
    {
        
        $daysOrder = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        $allHours = $openingHoursRepository->findAll();

        $hoursByDay = [];
        foreach ($allHours as $hours) {
            $hoursByDay[$hours->getDay()] = $hours;
        }

        $orderedHours = [];
        foreach ($daysOrder as $day) {
            $orderedHours[] = $hoursByDay[$day] ?? null;
        }

        return $this->render('public/main/_partials/_footer.html.twig', [
            'openingHours' => $orderedHours,
            'days' => $daysOrder
        ]);
    }
}