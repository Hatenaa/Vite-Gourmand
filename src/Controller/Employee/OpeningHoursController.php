<?php

namespace App\Controller\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\OpeningHours;
use App\Form\OpeningHoursType;

#[Route('/espace-employe/horaires', name: 'employee_opening_hours_')]
class OpeningHoursController extends AbstractController
{
    #[Route('', name: 'list')]
    public function openingHoursList(Request $request, EntityManagerInterface $entityManager): Response
    {
        $openingHours = $entityManager->getRepository(OpeningHours::class)->findAll();

        return $this->render('employee/opening_hours_list.html.twig', [
            'opening_hours' => $openingHours
        ]);
    }


    #[Route('/{id}/modifier', name: 'edit')]
    public function openingHoursEdit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $openingHours = $entityManager->getRepository(OpeningHours::class)->find($id);

        if(!$openingHours){
            throw $this->createNotFoundException('Horaire du traiteur introuvable.');
        }

        $form = $this->createForm(OpeningHoursType::class, $openingHours);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $entityManager->flush();

            $this->addFlash('success', 'Horaires modifiées avec succès.');
            return $this->redirectToRoute('employee_opening_hours_list');
        }

        return $this->render('employee/opening_hours_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier une horaire'
        ]);
    }
}