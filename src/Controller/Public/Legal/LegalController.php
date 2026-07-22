<?php

namespace App\Controller\Public\Legal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'legal_mentions')]
    public function mentions(): Response
    {
        return $this->render('public/legal/mentions.html.twig');
    }

    #[Route('/conditions-generales-de-vente', name: 'legal_cgv')]
    public function cgv(): Response
    {
        return $this->render('public/legal/cgv.html.twig');
    }
}