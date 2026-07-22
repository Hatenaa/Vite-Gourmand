<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\Entity\MenuImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MenuImageFixtures extends Fixture implements DependentFixtureInterface
{
    public const IMAGE_MENU_APERITIF = 'image_menu_aperitif';
    public const IMAGE_MENU_NOEL_PRESTIGE_1 = 'image_menu_de_noel_prestige_1';
    public const IMAGE_MENU_NOEL_MEDITERRANEEN_1 = 'image_menu_de_noel_mediterraneen_1';
    public const IMAGE_MENU_DECOUVERTE_1 = 'image_menu_decouverte_1';
    public const IMAGE_MENU_DOLCE_VITA_1 = 'image_menu_dolce_vita_1';
    public const IMAGE_MENU_MATINAL_1 = 'image_menu_matinal_1';
    public const IMAGE_MENU_PRINTEMPS_1 = 'image_menu_printemps_1';
    public const IMAGE_MENU_SOUPE_1 = 'image_menu_soupe_1';
    public const IMAGE_MENU_TRADITION_FRANCAISE_1 = 'image_menu_tradition_francaise_1';
    public const IMAGE_MENU_VEGETARIEN_1 = 'image_menu_vegetarien_1';
    public function load(ObjectManager $manager): void
    {
        $imagesData = [
            [
                'reference' => self::IMAGE_MENU_APERITIF,
                'menuReference' => MenuFixtures::MENU_APERITIF,
                'path' => 'images/menus/menu-aperitif/menu-aperitif.jpg',
                'alt' => 'Menu Apéritif',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_NOEL_PRESTIGE_1,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'path' => 'images/menus/menu-de-noel-prestige/menu-de-noel-prestige.jpg',
                'alt' => 'Menu de Noël Prestige',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_NOEL_MEDITERRANEEN_1,
                'menuReference' => MenuFixtures::MENU_MEDITERRANEEN,
                'path' => 'images/menus/menu-mediterraneen/menu-mediterraneen.jpg',
                'alt' => 'Menu Méditerranéen',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_DECOUVERTE_1,
                'menuReference' => MenuFixtures::MENU_DECOUVERTE,
                'path' => 'images/menus/menu-decouverte/menu-decouverte.jpg',
                'alt' => 'Menu Découverte',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_DOLCE_VITA_1,
                'menuReference' => MenuFixtures::MENU_DOLCE_VITA,
                'path' => 'images/menus/menu-dolce-vita/menu-dolce-vita.jpg',
                'alt' => 'Menu Dolce Vita',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_MATINAL_1,
                'menuReference' => MenuFixtures::MENU_MATINAL,
                'path' => 'images/menus/menu-matinal/menu-matinal.jpg',
                'alt' => 'Menu Matinal',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_PRINTEMPS_1,
                'menuReference' => MenuFixtures::MENU_PRINTEMPS,
                'path' => 'images/menus/menu-printemps/menu-printemps.jpg',
                'alt' => 'Menu Printemps',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_SOUPE_1,
                'menuReference' => MenuFixtures::MENU_SOUPE,
                'path' => 'images/menus/menu-soupe/menu-soupe.jpg',
                'alt' => 'Menu Soupé',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_TRADITION_FRANCAISE_1,
                'menuReference' => MenuFixtures::MENU_TRADITION_FRANCAISE,
                'path' => 'images/menus/menu-tradition-francaise/menu-tradition-francaise.jpg',
                'alt' => 'Menu Tradition Française',
                'position' => 1,
            ],
            [
                'reference' => self::IMAGE_MENU_VEGETARIEN_1,
                'menuReference' => MenuFixtures::MENU_VEGETARIEN,
                'path' => 'images/menus/menu-vegetarien/menu-vegetarien.jpg',
                'alt' => 'Menu Végétarien',
                'position' => 1,
            ],
        ];

        foreach ($imagesData as $data) {
            $image = new MenuImage();

            $image->setPath($data['path']);
            $image->setAlt($data['alt']);
            $image->setPosition($data['position']);
            $image->setMenu($this->getReference($data['menuReference'], Menu::class));

            $manager->persist($image);

            $this->addReference($data['reference'], $image);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MenuFixtures::class
        ];
    }
}
