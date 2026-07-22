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

        // Pour éviter de se répéter, on va grouper les jours qui ont les mêmes horaires dans le footer
        $groups = [];
        $lastKey = null;

        foreach ($orderedHours as $i => $hours) {
            $key = ($hours && !$hours->isClosed())
                ? $hours->getOpeningTime()->format('H:i') . '-' . $hours->getClosingTime()->format('H:i')
                : 'closed';

            if ($lastKey === $key && !empty($groups)) {
                $groups[array_key_last($groups)]['days'][] = $daysOrder[$i];
            } else {
                $groups[] = ['days' => [$daysOrder[$i]], 'hours' => $hours, 'key' => $key];
                $lastKey = $key;
            }
        }

        return $this->render('public/main/_partials/_footer.html.twig', [
            'groups' => $groups
        ]);
    }
}