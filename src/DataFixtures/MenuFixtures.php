<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Regime;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public const MENU_NOEL_PRESTIGE = 'menu_noel_prestige';
    public const MENU_TRADITION_FRANCAISE = 'menu_tradition_francaise';
    public const MENU_SOUPE = 'menu_soupe';
    public const MENU_DOLCE_VITA = 'menu_dolce_vita';
    public const MENU_DECOUVERTE = 'menu_decouverte';
    public const MENU_VEGETARIEN = 'menu_vegetarien';
    public const MENU_MATINAL = 'menu_matinal';
    public const MENU_PRINTEMPS = 'menu_printemps';
    public const MENU_APERITIF = 'menu_aperitif';
    public const MENU_MEDITERRANEEN = 'menu_mediterraneen';

    public function load(ObjectManager $manager): void
    {
        $menusData = [
            [
                'reference' => self::MENU_NOEL_PRESTIGE,
                'title' => 'Noël Prestige',
                'description' => 'Un menu festif complet pour les repas de fin d’année.',
                'minPeople' => 4,
                'basePrice' => '89.00',
                'conditions' => 'Commande à effectuer au moins 7 jours avant la prestation. Conservation au frais recommandée.',
                'stock' => 5,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_NOEL,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_FOIE_GRAS_PAIN_BRIOCHE,
                    DishFixtures::DISH_SUPREME_VOLAILLE,
                    DishFixtures::DISH_BUCHE_CHOCOLAT_PRALINE,
                ],
            ],
            [
                'reference' => self::MENU_TRADITION_FRANCAISE,
                'title' => 'Tradition Française',
                'description' => 'Un menu généreux inspiré des grands classiques de la cuisine française.',
                'minPeople' => 4,
                'basePrice' => '32.00',
                'conditions' => 'Commande à effectuer au moins 5 jours avant la prestation.',
                'stock' => 8,
                'isActive' => false,
                'themeReference' => ThemeFixtures::THEME_TRADITION,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_BOEUF_BOURGUIGNON,
                    DishFixtures::DISH_GRATIN_DAUPHINOIS,
                    DishFixtures::DISH_TARTE_TATIN,
                ],
            ],
            [
                'reference' => self::MENU_SOUPE,
                'title' => 'Soupé',
                'description' => 'Un menu réconfortant autour de saveurs chaudes et authentiques.',
                'minPeople' => 4,
                'basePrice' => '26.00',
                'conditions' => 'Commande à effectuer au moins 3 jours avant la prestation.',
                'stock' => 10,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_HIVER,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_SOUP_OIGNON,
                    DishFixtures::DISH_VELOUTE_POTIMARRON,
                ],
            ],
            [
                'reference' => self::MENU_DOLCE_VITA,
                'title' => 'Dolce Vita',
                'description' => 'Un menu ensoleillé inspiré de l’Italie, entre convivialité et gourmandise.',
                'minPeople' => 4,
                'basePrice' => '24.00',
                'conditions' => 'Commande à effectuer au moins 4 jours avant la prestation.',
                'stock' => 9,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_MEDITERRANEEN,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_BRUSCHETTA,
                    DishFixtures::DISH_LASAGNES,
                    DishFixtures::DISH_TIRAMISU,
                ],
            ],
            [
                'reference' => self::MENU_DECOUVERTE,
                'title' => 'Découverte',
                'description' => 'Une sélection variée de créations fraîches et modernes pour éveiller les papilles.',
                'minPeople' => 2,
                'basePrice' => '28.00',
                'conditions' => 'Commande à effectuer au moins 3 jours avant la prestation.',
                'stock' => 12,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_DECOUVERTE,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_WRAP_POULET,
                    DishFixtures::DISH_VERRINE_AVOCAT,
                ],
            ],
            [
                'reference' => self::MENU_VEGETARIEN,
                'title' => 'Végétarien',
                'description' => 'Un menu équilibré et gourmand, riche en légumes, textures et saveurs.',
                'minPeople' => 4,
                'basePrice' => '24.00',
                'conditions' => 'Commande à effectuer au moins 4 jours avant la prestation.',
                'stock' => 10,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_NATURE,
                'regimeReference' => RegimeFixtures::REGIME_VEGETARIEN,
                'dishReferences' => [
                    DishFixtures::DISH_SALADE_MEDITERRANEENNE,
                    DishFixtures::DISH_CURRY_LEGUMES,
                    DishFixtures::DISH_CHEESECAKE,
                ],
            ],
            [
                'reference' => self::MENU_MATINAL,
                'title' => 'Matinal',
                'description' => 'Un menu pensé pour les petits-déjeuners et pauses matinales conviviales.',
                'minPeople' => 6,
                'basePrice' => '28.00',
                'conditions' => 'Commande à effectuer au moins 2 jours avant la prestation.',
                'stock' => 15,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_BRUNCH,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_VIENNOISERIES,
                    DishFixtures::DISH_PANCAKES,
                ],
            ],
            [
                'reference' => self::MENU_PRINTEMPS,
                'title' => 'Printemps',
                'description' => 'Un menu frais et coloré qui met à l’honneur les produits de saison.',
                'minPeople' => 6,
                'basePrice' => '38.00',
                'conditions' => 'Commande à effectuer au moins 5 jours avant la prestation.',
                'stock' => 7,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_PRINTEMPS,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_SALADE_MEDITERRANEENNE,
                    DishFixtures::DISH_POULET_HERBES,
                    DishFixtures::DISH_TARTE_FRAISES,
                ],
            ],
            [
                'reference' => self::MENU_APERITIF,
                'title' => 'Apéritif',
                'description' => 'Une formule conviviale idéale pour les cocktails, afterworks et réceptions.',
                'minPeople' => 2,
                'basePrice' => '22.00',
                'conditions' => 'Commande à effectuer au moins 3 jours avant la prestation.',
                'stock' => 14,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_FESTIF,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_MINI_BURGERS,
                    DishFixtures::DISH_FEUILLETES,
                ],
            ],
            [
                'reference' => self::MENU_MEDITERRANEEN,
                'title' => 'Méditerranéen',
                'description' => 'Un menu chaleureux et méditerranéen autour des saveurs italiennes.',
                'minPeople' => 4,
                'basePrice' => '24.00',
                'conditions' => 'Commande à effectuer au moins 4 jours avant la prestation.',
                'stock' => 9,
                'isActive' => true,
                'themeReference' => ThemeFixtures::THEME_MEDITERRANEEN,
                'regimeReference' => RegimeFixtures::REGIME_CLASSIQUE,
                'dishReferences' => [
                    DishFixtures::DISH_FOCACCIA,
                    DishFixtures::DISH_LASAGNES,
                    DishFixtures::DISH_PANNA_COTTA,
                ],
            ],
        ];

        foreach ($menusData as $data) {
            $menu = new Menu();

            $menu->setTitle($data['title']);
            $menu->setDescription($data['description']);
            $menu->setMinPeople($data['minPeople']);
            $menu->setBasePrice($data['basePrice']);
            $menu->setConditions($data['conditions']);
            $menu->setStock($data['stock']);
            $menu->setCreatedAt(new \DateTimeImmutable());
            $menu->setIsActive($data['isActive']);

            $menu->setTheme(
                $this->getReference($data['themeReference'], Theme::class)
            );

            $menu->setRegime(
                $this->getReference($data['regimeReference'], Regime::class)
            );

            foreach ($data['dishReferences'] as $dishReference) {
                $menu->addDish(
                    $this->getReference($dishReference, Dish::class)
                );
            }

            $manager->persist($menu);

            $this->addReference($data['reference'], $menu);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ThemeFixtures::class,
            RegimeFixtures::class,
            DishFixtures::class,
        ];
    }
}