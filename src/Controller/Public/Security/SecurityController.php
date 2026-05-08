<?php

namespace App\Controller\Public\Security;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        $form = $this->createForm(LoginType::class);

        return $this->render('public/security/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $error,
        ]);
    }

    #[Route('/connexion/check', name: 'login_check')]
    public function loginCheck(Request $request): never
    {
       throw new \LogicException('This method should not be reached.');
    }

    #[Route('/connexion/erreur', name: 'login_error')]
    public function loginError(): Response
    {
        $this->addFlash('error', 'Identifiants invalides. Veuillez réessayer.');
        return $this->redirectToRoute('login');
    }

    #[Route('/connexion/success', name: 'login_success')]
    public function loginSuccess(): Response
    {
        $this->addFlash('success', 'Connexion réussie. Bienvenue !');
        return $this->redirectToRoute('home');
    }

    #[Route('/deconnexion', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}