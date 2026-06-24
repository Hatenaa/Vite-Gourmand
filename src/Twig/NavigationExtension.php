<?php

namespace App\Twig;

use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class NavigationExtension extends AbstractExtension
{
    public function __construct (private Security $security) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nav_links', [$this, 'getLinks'])
        ];
    }

    public function getLinks(string $context = 'public'): array
    {

        // Liens publiques
        $links = [
            ['route' => 'home', 'label' => 'Accueil'],
            ['route' => 'menu_index', 'label' => 'Menus'],
            ['route' => 'contact', 'label' => 'Contact'],
        ];

        // Si l'utilisateur est connecté
        if ($this->security->getUser()) {

            if ($this->security->isGranted('ROLE_ADMIN')) {
                $links[] = ['route' => 'admin_dashboard', 'label' => 'Espace administrateur'];
                $links[] = ['route' => 'employee_dashboard', 'label' => 'Espace employée'];

            } elseif ($this->security->isGranted('ROLE_EMPLOYE')) {
                $links[] = ['route' => 'employee_dashboard', 'label' => 'Espace employée'];
            }

            $links[] = ['route' => 'user_dashboard', 'label' => 'Mon espace'];
            $links[] = ['route' => 'logout', 'label' => 'Déconnexion'];

        } elseif ($context === 'public') {

            $links[] = ['route' => 'login', 'label' => 'Connexion'];
            $links[] = ['route' => 'registration', 'label' => 'Inscription', 'variant' => 'button-outline'];
            $links[] = ['route' => 'order_new', 'label' => 'Commander', 'variant' => 'button-primary', 'icon' => 'bi-arrow-right'];
        }

        return $links;
    }
}