<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\CreateEmployeeType;
use App\Form\EditEmployeeType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/espace-admin/comptes', name: 'admin_account_')]
class AccountController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(UserRepository $userRepository): Response
    {
        $employees = $userRepository->findByRole('ROLE_EMPLOYEE');
        return $this->render('admin/account_list.html.twig', [
            'employees' => $employees
        ]);
    }


    #[Route('/creer', name: 'create')]
    public function employeeCreate(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher,
        MailerInterface $mailer
    ): Response {

        $user = new User();
        $form = $this->createForm(CreateEmployeeType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $plain = $form->get('plainPassword')->getData();
            $user->setPassword($hasher->hashPassword($user, $plain));
            $user->setRoles(['ROLE_EMPLOYEE']);
            $user->setIsActive(true);
            $user->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->to($user->getEmail())
                ->subject('Votre compte employée Vite & Gourmand')
                ->htmlTemplate('emails/employee_account_created.html.twig')
                ->context(['user' => $user]);
            $mailer->send($email);

            $this->addFlash('success', 'Compte employé créé.');
            return $this->redirectToRoute('admin_account_list');
        }

        return $this->render('admin/account_create.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/{id}/modifier', name: 'edit')]
    public function employeeEdit(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher
    ): Response {

        $user = $entityManager->getRepository(User::class)->find($id);

        if(!$user){
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(EditEmployeeType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $plain = $form->get('plainPassword')->getData();
            if($plain){
                $user->setPassword($hasher->hashPassword($user, $plain));
            }

            $entityManager->flush();

            $this->addFlash('success', 'Compte mis à jour.');
            return $this->redirectToRoute('admin_account_list');
        }

        return $this->render('admin/account_edit.html.twig', [
            'form' => $form,
            'employee' => $user
        ]);
    }


    #[Route('/{id}/supprimer', name:'delete', methods: ['POST'])]
    public function employeeDelete(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        if(!$user){
            throw $this->createNotFoundException('Utilisateur indisponible ou inexistant.');
        }

        if($this->isCsrfTokenValid('delete_employee_' . $id, $request->request->get('_token'))){
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Compte supprimé.');
        }

        return $this->redirectToRoute('admin_account_list');
    }


    #[Route('/{id}/toggle', name: 'toggle', methods: ['POST'])]
    public function employeeToggle(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if(!$user){
            throw $this->createNotFoundException('Utilisateur indisponible ou inexistant.');
        }

        if(!$this->isCsrfTokenValid('toggle_employee_' . $id, $request->request->get('_token'))){
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('admin_account_list');
        }

        $user->setIsActive(!$user->isActive());
        $entityManager->flush();

        $this->addFlash('success', 'Compte mis à jour.');
        return $this->redirectToRoute('admin_account_list');
    }
}

