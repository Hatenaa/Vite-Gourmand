<?php

namespace App\DataFixtures;

use App\Entity\Regime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegimeFixtures extends Fixture
{
    public const REGIME_CLASSIQUE = 'regime_classique';
    public const REGIME_VEGETARIEN = 'regime_vegetarien';
    public const REGIME_VEGAN = 'regime_vegan';

    public function load(ObjectManager $manager): void
    {
        $regimesData = [
            [
                'reference' => self::REGIME_CLASSIQUE,
                'label' => 'Classique',
                'description' => 'Une cuisine équilibrée et savoureuse, fidèle aux traditions gourmandes.'
            ],
            [
                'reference' => self::REGIME_VEGETARIEN,
                'label' => 'Végétarien',
                'description' => 'Des créations généreuses et créatives, mettant à l’honneur les produits végétaux.'
            ],
            [
                'reference' => self::REGIME_VEGAN,
                'label' => 'Vegan',
                'description' => 'Une cuisine 100% végétale, inventive et pleine de saveurs naturelles.'
            ]
        ];

        foreach ($regimesData as $data) {
            $regime = new Regime();
            $regime->setLabel($data['label']);
            $regime->setDescription($data['description']);

            $manager->persist($regime);
            $this->addReference($data['reference'], $regime);
        }

        $manager->flush();
    }
}
