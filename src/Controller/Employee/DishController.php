<?php

namespace App\Controller\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Dish;
use App\Form\DishType;

#[Route('/espace-employe/plats', name: 'employee_dish_')]
class DishController extends AbstractController
{
    #[Route('', name: 'list')]
    public function dishList(EntityManagerInterface $entityManager): Response
    {
        $dishes = $entityManager->getRepository(Dish::class)->findAll();

        return $this->render('employee/dish_list.html.twig', [
            'dishes' => $dishes
        ]);
    }

    #[Route('/creer', name: 'create')]
    public function dishCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dish = new Dish();

        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {

                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/dishes',
                    $newFilename
                );
                $dish->setImage($newFilename);
            }

            $entityManager->persist($dish);
            $entityManager->flush();

            $this->addFlash('success', 'Plat créé avec succès.');
            return $this->redirectToRoute('employee_dish_list');
        }

        return $this->render('employee/dish_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Créer un plat',
        ]);
    }


    #[Route('/{id}/modifier', name: 'edit')]
    public function dishEdit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $dish = $entityManager->getRepository(Dish::class)->find($id);

        if (!$dish) {
            throw $this->createNotFoundException('Plat introuvable.');
        }

        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {

                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/dishes',
                    $newFilename
                );
                $dish->setImage($newFilename);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Plat modifié avec succès.');
            return $this->redirectToRoute('employee_dish_list');
        }

        return $this->render('employee/dish_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier un plat',
            'dish' => $dish,
        ]);
    }


    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function dishDelete(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $dish = $entityManager->getRepository(Dish::class)->find($id);

        if (!$dish) {
            throw $this->createNotFoundException('Plat introuvable.');
        }

        if (!$this->isCsrfTokenValid('delete_dish_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('employee_dish_list');
        }

        $entityManager->remove($dish);
        $entityManager->flush();

        $this->addFlash('success', 'Plat supprimé avec succès.');
        return $this->redirectToRoute('employee_dish_list');
    }
}