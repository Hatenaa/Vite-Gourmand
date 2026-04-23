<?php

namespace App\DataFixtures;

use App\Entity\Allergen;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AllergenFixtures extends Fixture
{
    public const ALLERGEN_GLUTEN = 'allergen_gluten';
    public const ALLERGEN_CRUSTACE = 'allergen_crustace';
    public const ALLERGEN_OEUF = 'allergen_oeuf';
    public const ALLERGEN_POISSON = 'allergen_poisson';
    public const ALLERGEN_ARACHIDE = 'allergen_arachide';
    public const ALLERGEN_SOJA = 'allergen_soja';
    public const ALLERGEN_LAIT = 'allergen_lait';
    public const ALLERGEN_FRUITS_A_COQUE = 'allergen_fruits_a_coque';
    public const ALLERGEN_CELERI = 'allergen_celeri';
    public const ALLERGEN_MOUTARDE = 'allergen_moutarde';
    public const ALLERGEN_MOLLUSQUE = 'allergen_mollusque';
    public const ALLERGEN_SESAME = 'allergen_sesame';
    public const ALLERGEN_SULFITE = 'allergen_sulfite';
    public const ALLERGEN_LUPIN = 'allergen_lupin';

    public function load(ObjectManager $manager): void
    {
        $allergensData = [
            [
                'reference' => self::ALLERGEN_GLUTEN,
                'label' => 'Gluten',
            ],
            [
                'reference' => self::ALLERGEN_CRUSTACE,
                'label' => 'Crustacé',
            ],
            [
                'reference' => self::ALLERGEN_OEUF,
                'label' => 'Œuf',
            ],
            [
                'reference' => self::ALLERGEN_POISSON,
                'label' => 'Poisson',
            ],
            [
                'reference' => self::ALLERGEN_ARACHIDE,
                'label' => 'Arachide',
            ],
            [
                'reference' => self::ALLERGEN_SOJA,
                'label' => 'Soja',
            ],
            [
                'reference' => self::ALLERGEN_LAIT,
                'label' => 'Lait',
            ],
            [
                'reference' => self::ALLERGEN_FRUITS_A_COQUE,
                'label' => 'Fruits à coque',
            ],
            [
                'reference' => self::ALLERGEN_CELERI,
                'label' => 'Céleri',
            ],
            [
                'reference' => self::ALLERGEN_MOUTARDE,
                'label' => 'Moutarde',
            ],
            [
                'reference' => self::ALLERGEN_MOLLUSQUE,
                'label' => 'Mollusque',
            ],
            [
                'reference' => self::ALLERGEN_SESAME,
                'label' => 'Sésame',
            ],
            [
                'reference' => self::ALLERGEN_SULFITE,
                'label' => 'Sulfite',
            ],
            [
                'reference' => self::ALLERGEN_LUPIN,
                'label' => 'Lupin',
            ],
        ];

        foreach($allergensData as $data) {
            $allergen = new Allergen();

            $allergen->setLabel($data['label']);
            $manager->persist($allergen);

            $this->addReference($data['reference'], $allergen);
        }

        $manager->flush();
    }
}
