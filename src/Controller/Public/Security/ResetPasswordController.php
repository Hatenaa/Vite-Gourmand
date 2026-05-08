<?php

namespace App\Controller\Public\Security;

use App\Entity\User;
use App\Form\ResetPasswordRequestType;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class ResetPasswordController extends AbstractController
{
    #[Route('/mot-de-passe-oublie', name: 'forgot_password_request')]
    public function request(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {

                $token = Uuid::v4()->toRfc4122();
                $user->setResetToken($token);
                $user->setResetTokenExpiresAt(new \DateTimeImmutable('+1 hour'));
                $em->flush();

                $emailMessage = (new TemplatedEmail())
                    ->form('noreply@vite-et-gourmand.fr')
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de votre mot de passe')
                    ->htmlTemplate('emails/reset_password.html.twig')
                    ->context([
                        'resetToken' => $token,
                    ])
                ;

                $mailer->send($emailMessage);
            }

            $this->addFlash('success', 'Si un compte existe avec cet email, un lien de réinitialisation a été envoyé.');
            return $this->redirectToRoute('login');
        }

        return $this->render('public/security/reset_password_request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('/reintiliasier-mot-de-passe/{token}', name: 'reset_password')]
    public function reset(string $token, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
            $user = $em->getRepository(User::class)->findOneBy(['resetToken' => $token]);

            if (!$user || $user->getResetTokenExpiresAt() < new \DateTimeImmutable()) {
                $this->addFlash('error', 'Le lien de réinitialisation est invalide ou a expiré.');
                return $this->redirectToRoute('forgot_password_request');
            }

            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newPassword = $form->get('plainPassword')->getData();
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                $user->setResetToken(null);
                $user->setResetTokenExpiresAt(null);
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
                return $this->redirectToRoute('login');
            }

            return $this->render('public/security/reset_password.html.twig', [
                'resetForm' => $form->createView(),
            ]);
    }
}