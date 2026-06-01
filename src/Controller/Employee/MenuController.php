<?php

namespace App\Controller\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Menu;
use App\Form\MenuType;
use App\Entity\MenuImage;
use App\Form\MenuImageType;

#[Route('/espace-employe/menus', name: 'employee_menu_')]
class MenuController extends AbstractController
{
    #[Route('', name: 'list')]
    public function menuList(EntityManagerInterface $entityManager): Response
    {
        $menus = $entityManager->getRepository(Menu::class)->findAll();

        return $this->render('employee/menu_list.html.twig', [
            'menus' => $menus
        ]);
    }

    #[Route('/creer', name: 'create')]
    public function menuCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $menu->setCreatedAt(new \DateTimeImmutable());
        $menu->setIsActive(true);

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menu);
            $entityManager->flush();

            $this->addFlash('success', 'Menu crée avec succès.');
            return $this->redirectToRoute('employee_menu_list');
        }

        return $this->render('employee/menu_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Créer un menu'
        ]);
    }


    #[Route('/{id}/modifier', name: 'edit')]
    public function menuEdit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = $entityManager->getRepository(Menu::class)->find($id);

        if (!$menu) {
            throw $this->createNotFoundException('Menu introuvable.');
        }

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Menu modifié avec succès.');
            return $this->redirectToRoute('employee_menu_list');
        }

        return $this->render('employee/menu_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier un menu',
            'menu' => $menu,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function menuDelete(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = $entityManager->getRepository(Menu::class)->find($id);

        if (!$menu) {
            throw $this->createNotFoundException('Menu introuvable.');
        }

        if (!$this->isCsrfTokenValid('delete_menu_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('employee_menu_list');
        }

        $entityManager->remove($menu);
        $entityManager->flush();

        $this->addFlash('success', 'Menu supprimé avec succès.');
        return $this->redirectToRoute('employee_menu_list');
    }


    #[Route('/{id}/images', name: 'images')]
    public function menuImages(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = $entityManager->getRepository(Menu::class)->find($id);

        if(!$menu){
            throw $this->createNotFoundException('Menu introuvable.');
        }

        $form = $this->createForm(MenuImageType::class);
        $form->handleRequest($request);

        return $this->render('employee/menu_images.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);

    }

    
    #[Route('/{id}/images/ajouter', name: 'image_add', methods: ['POST'])]
    public function imageAdd(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = $entityManager->getRepository(Menu::class)->find($id);

        if(!$menu){
            throw $this->createNotFoundException('Menu introuvable.');
        }

        $menuImage = new MenuImage();
        $form = $this->createForm(MenuImageType::class, $menuImage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $imageFile = $form->get('imageFile')->getData();
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('kernel.project_dir') . '/public/uploads/menus',
                $newFilename
            );

            $menuImage->setPath('uploads/menus/' . $newFilename);
            $menuImage->setMenu($menu);

            $entityManager->persist($menuImage);
            $entityManager->flush();

            $this->addFlash('success', 'Image ajoutée.');
        }

        return $this->redirectToRoute('employee_menu_images', ['id' => $id]);
    }



    #[Route('/{id}/images/{imageId}/supprimer', name: 'image_delete', methods: ['POST'])]
    public function imageDelete(int $id, int $imageId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = $entityManager->getRepository(Menu::class)->find($id);

        if(!$menu){
            throw $this->createNotFoundException('Menu introuvable');
        }

        $menuImage = $entityManager->getRepository(MenuImage::class)->find($imageId);

        if(!$menuImage){
            throw $this->createNotFoundException('Image du menu introuvable.');
        }

        if($menuImage->getMenu() !== $menu){
            throw $this->createNotFoundException('Image non associé à ce menu.');
        }

        if(!$this->isCsrfTokenValid('delete_menu_image' . $imageId, $request->request->get('_token'))){
            $this->addFlash('error', 'Action non autorisée');
            return $this->redirectToRoute('employee_menu_images', ['id' => $id]);
        }

        $entityManager->remove($menuImage);
        $entityManager->flush();

        $this->addFlash('success', 'Image du menu supprimée avec succès.');
        return $this->redirectToRoute('employee_menu_images', ['id' => $id]);
    }
}