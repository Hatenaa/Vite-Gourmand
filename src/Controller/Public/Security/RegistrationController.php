<?php

namespace App\Controller\Public\Security;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'registration')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response
    {
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        // Si l'utilisateur viens d'un menu...
        $fromMenu = $request->query->get('from_menu');
        
        if ($fromMenu) {
            $request->getSession()->set('from_menu', $fromMenu);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($hashedPassword);

            $user->setRoles(['ROLE_USER']);
            $user->setIsActive(true);
            $user->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new Email())
            ->to($user->getEmail())
            ->subject('Bienvenue chez Vite & Gourmand !')
            ->html('<p>Bonjour ' . $user->getFirstName() . ',</p><p>Votre compte a bien été créé. Bienvenue !</p>');

            $mailer->send($email);

            if ($fromMenu) {

                $this->addFlash('success', 'Votre compte a été créé avec succès. Un email de bienvenue vous a été envoyé. Vous pouvez maintenant commander le menu que vous avez sélectionné.');
                $request->getSession()->remove('from_menu');

                return $this->redirectToRoute('login', [
                    '_target_path' => $this->generateUrl('menu_show', ['id' => $fromMenu])
                    // Quand la partie commande sera disponible: '_target_path' => $this->generateUrl('order_menu', ['id' => $fromMenu])
                ]);

            } else {

                $this->addFlash('success', 'Votre compte a été créé avec succès. Un email de bienvenue vous a été envoyé.');
                return $this->redirectToRoute('home');
            }

        }

        return $this->render('public/registration/registration.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
