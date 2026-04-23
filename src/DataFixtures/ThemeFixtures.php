<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{
    public const THEME_NOEL = 'theme_noel';
    public const THEME_PAQUES = 'theme_paques';
    public const THEME_CLASSIQUE = 'theme_classique';
    public const THEME_EVENEMENT = 'theme_evenement';
    public const THEME_SEASONAL = 'theme_saisonnier';
    public const THEME_FESTIF = 'theme_festif';
    public const THEME_MEDITERRANEEN = 'theme_mediterraneen';
    public const THEME_TRADITION = 'theme_tradition';
    public const THEME_HIVER = 'theme_hiver';
    public const THEME_DECOUVERTE = 'decouverte';
    public const THEME_NATURE = 'theme_nature';
    public const THEME_BRUNCH = 'theme_brunch';
    public const THEME_PRINTEMPS = 'theme_printemps';

    public function load(ObjectManager $manager): void
    {
        $themesData = [
            [
                'reference' => self::THEME_NOEL,
                'label' => 'Noël',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_PAQUES,
                'label' => 'Paques',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_CLASSIQUE,
                'label' => 'Classique',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_EVENEMENT,
                'label' => 'Évènement',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_SEASONAL,
                'label' => 'Saisonnier',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_FESTIF,
                'label' => 'Festif',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_MEDITERRANEEN,
                'label' => 'Méditerraneen',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_TRADITION,
                'label' => 'Tradition',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_HIVER,
                'label' => 'Hiver',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_DECOUVERTE,
                'label' => 'Découverte',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_NATURE,
                'label' => 'Nature',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_BRUNCH,
                'label' => 'Brunch',
                'isActive' => true
            ],
            [
                'reference' => self::THEME_PRINTEMPS,
                'label' => 'Printemps',
                'isActive' => true
            ],

        ];

        foreach ($themesData as $data) {
            $theme = new Theme();
            $theme->setLabel($data['label']);
            $theme->setIsActive($data['isActive']);

            $manager->persist($theme);
            $this->addReference($data['reference'], $theme);
        }
        

        $manager->flush();
    }
}
