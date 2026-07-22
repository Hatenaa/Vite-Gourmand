<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DishFixtures extends Fixture implements DependentFixtureInterface
{
    public const DISH_FOIE_GRAS_PAIN_BRIOCHE = 'dish_foie_gras_pain_brioche';
    public const DISH_SUPREME_VOLAILLE = 'dish_suppreme_volaille';
    public const DISH_BUCHE_CHOCOLAT_PRALINE = 'dish_buche_chocolat_praline';
    public const DISH_BOEUF_BOURGUIGNON = 'dish_boeuf_bourguignon';
    public const DISH_GRATIN_DAUPHINOIS = 'dish_gratin_dauphinois';
    public const DISH_TARTE_TATIN = 'dish_tarte_tatin';
    public const DISH_SOUP_OIGNON = 'dish_soup_oignon';
    public const DISH_VELOUTE_POTIMARRON = 'dish_veloute_potimarron';
    public const DISH_BRUSCHETTA = 'dish_bruschetta';
    public const DISH_LASAGNES = 'dish_lasagnes';
    public const DISH_TIRAMISU = 'dish_tiramisu';
    public const DISH_WRAP_POULET = 'dish_wrap_poulet';
    public const DISH_VERRINE_AVOCAT = 'dish_verrine_avocat';
    public const DISH_SALADE_MEDITERRANEENNE = 'dish_salade_mediterraneenne';
    public const DISH_CURRY_LEGUMES = 'dish_curry_legumes';
    public const DISH_CHEESECAKE = 'dish_cheesecake';
    public const DISH_VIENNOISERIES = 'dish_viennoiseries';
    public const DISH_PANCAKES = 'dish_pancakes';
    public const DISH_POULET_HERBES = 'dish_poulet_herbes';
    public const DISH_TARTE_FRAISES = 'dish_tarte_fraises';
    public const DISH_MINI_BURGERS = 'dish_mini_burgers';
    public const DISH_FEUILLETES = 'dish_feuilletes';
    public const DISH_FOCACCIA = 'dish_focaccia';
    public const DISH_PANNA_COTTA = 'dish_panna_cotta';
    public function load(ObjectManager $manager): void
    {
        $dishesData = 

            [
                // Menu fin d'année
                [
                    'reference' => self::DISH_FOIE_GRAS_PAIN_BRIOCHE,
                    'allergens' => [],
                    'title' => 'Foie gras maison et pain brioché',
                    'description' => 'Foie gras maison délicatement assaisonné, accompagné de tranches de pain brioché légèrement toastées.',
                    'type' => 'STARTER',
                ],
                [
                    'reference' => self::DISH_SUPREME_VOLAILLE,
                    'allergens' => [],
                    'title' => 'Suprême de volaille sauce morilles',
                    'description' => 'Suprême de volaille tendre nappé d’une sauce crémeuse aux morilles, servi avec accompagnement de saison.',
                    'type' => 'MAIN',
                ],
                [
                    'reference' => self::DISH_BUCHE_CHOCOLAT_PRALINE,
                    'allergens' => [],
                    'title' => 'Bûche chocolat praliné',
                    'description' => 'Bûche de Noël gourmande au chocolat noir et praliné croustillant, alliant douceur et intensité.',
                    'type' => 'DESSERT',
                ],

                // Tradition française
                [
                    'reference' => self::DISH_BOEUF_BOURGUIGNON,
                    'allergens' => [],
                    'title' => 'Bœuf bourguignon mijoté',
                    'description' => 'Plat traditionnel français mijoté au vin rouge avec légumes.',
                    'type' => 'MAIN',
                ],
                [
                    'reference' => self::DISH_GRATIN_DAUPHINOIS,
                    'allergens' => [AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Gratin dauphinois fondant',
                    'description' => 'Pommes de terre fondantes gratinées à la crème.',
                    'type' => 'SIDE',
                ],
                [
                    'reference' => self::DISH_TARTE_TATIN,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN, AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Tarte tatin maison',
                    'description' => 'Dessert traditionnel aux pommes caramélisées.',
                    'type' => 'DESSERT',
                ],

                // Menu Soupé
                [
                    'reference' => self::DISH_SOUP_OIGNON,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN, AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Soupe à l’oignon gratinée',
                    'description' => 'Soupe traditionnelle gratinée au fromage.',
                    'type' => 'STARTER',
                ],
                [
                    'reference' => self::DISH_VELOUTE_POTIMARRON,
                    'allergens' => [AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Velouté de potimarron',
                    'description' => 'Velouté onctueux de potimarron légèrement épicé.',
                    'type' => 'STARTER',
                ],

                // Dolce Vita
                [
                    'reference' => self::DISH_BRUSCHETTA,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN],
                    'title' => 'Bruschetta tomate & basilic',
                    'description' => 'Pain grillé garni de tomates fraîches et basilic.',
                    'type' => 'STARTER',
                ],
                [
                    'reference' => self::DISH_LASAGNES,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN, AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Lasagnes à la bolognaise',
                    'description' => 'Lasagnes généreuses à la viande et béchamel.',
                    'type' => 'MAIN',
                ],
                [
                    'reference' => self::DISH_TIRAMISU,
                    'allergens' => [AllergenFixtures::ALLERGEN_LAIT, AllergenFixtures::ALLERGEN_OEUF],
                    'title' => 'Tiramisu classique',
                    'description' => 'Dessert italien au café et mascarpone.',
                    'type' => 'DESSERT',
                ],

                // Découverte
                [
                    'reference' => self::DISH_WRAP_POULET,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN],
                    'title' => 'Mini wraps poulet crudités',
                    'description' => 'Wraps frais garnis de poulet et légumes croquants.',
                    'type' => 'STARTER',
                ],
                [
                    'reference' => self::DISH_VERRINE_AVOCAT,
                    'allergens' => [AllergenFixtures::ALLERGEN_CRUSTACE],
                    'title' => 'Verrines avocat-crevettes',
                    'description' => 'Verrine fraîche à base d’avocat et crevettes.',
                    'type' => 'STARTER',
                ],

                // Végétarien
                [
                    'reference' => self::DISH_SALADE_MEDITERRANEENNE,
                    'allergens' => [],
                    'title' => 'Salade méditerranéenne',
                    'description' => 'Salade fraîche aux légumes de saison et herbes.',
                    'type' => 'STARTER',
                ],
                [
                    'reference' => self::DISH_CURRY_LEGUMES,
                    'allergens' => [],
                    'title' => 'Curry de légumes doux',
                    'description' => 'Curry parfumé aux légumes de saison.',
                    'type' => 'MAIN',
                ],
                [
                    'reference' => self::DISH_CHEESECAKE,
                    'allergens' => [AllergenFixtures::ALLERGEN_LAIT, AllergenFixtures::ALLERGEN_GLUTEN],
                    'title' => 'Cheesecake fruits rouges',
                    'description' => 'Dessert crémeux aux fruits rouges.',
                    'type' => 'DESSERT',
                ],

                // Matinal
                [
                    'reference' => self::DISH_VIENNOISERIES,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN, AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Viennoiseries assorties',
                    'description' => 'Sélection de croissants et pains au chocolat.',
                    'type' => 'DESSERT',
                ],
                [
                    'reference' => self::DISH_PANCAKES,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN, AllergenFixtures::ALLERGEN_OEUF, AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Pancakes au sirop d’érable',
                    'description' => 'Pancakes moelleux servis avec sirop d’érable.',
                    'type' => 'DESSERT',
                ],

                // Printemps
                [
                    'reference' => self::DISH_POULET_HERBES,
                    'allergens' => [],
                    'title' => 'Poulet rôti aux herbes',
                    'description' => 'Poulet rôti parfumé aux herbes fraîches.',
                    'type' => 'MAIN',
                ],
                [
                    'reference' => self::DISH_TARTE_FRAISES,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN, AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Tarte aux fraises',
                    'description' => 'Dessert frais à base de fraises de saison.',
                    'type' => 'DESSERT',
                ],

                // Apéritif
                [
                    'reference' => self::DISH_MINI_BURGERS,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN],
                    'title' => 'Mini burgers gourmets',
                    'description' => 'Petits burgers savoureux pour l’apéritif.',
                    'type' => 'STARTER',
                ],
                [
                    'reference' => self::DISH_FEUILLETES,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN, AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Feuilletés au fromage',
                    'description' => 'Bouchées feuilletées croustillantes au fromage.',
                    'type' => 'STARTER',
                ],

                // Dolce Vita (alternative)
                [
                    'reference' => self::DISH_FOCACCIA,
                    'allergens' => [AllergenFixtures::ALLERGEN_GLUTEN],
                    'title' => 'Focaccia maison',
                    'description' => 'Pain italien moelleux à l’huile d’olive.',
                    'type' => 'STARTER',
                ],
                [
                    'reference' => self::DISH_PANNA_COTTA,
                    'allergens' => [AllergenFixtures::ALLERGEN_LAIT],
                    'title' => 'Panna cotta vanille',
                    'description' => 'Dessert italien crémeux à la vanille.',
                    'type' => 'DESSERT',
                ],
            
        ];

        foreach ($dishesData as $data) {
            $dish = new Dish();
            $dish->setTitle($data['title']);
            $dish->setDescription($data['description']);
            $dish->setType($data['type']);

            foreach ($data['allergens'] as $allergenReference) {
                $dish->addAllergen(
                    $this->getReference($allergenReference, \App\Entity\Allergen::class)
                );
            }

            $manager->persist($dish);
            $this->addReference($data['reference'], $dish);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AllergenFixtures::class
        ];
    }
}
