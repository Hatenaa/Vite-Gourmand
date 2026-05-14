<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Menu;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public const ORDER_EMMA_DURAND_00001 = 'order_emma_durand_00001';
    public const ORDER_SARAH_PETIT_00002 = 'order_sarah_petit_00002';
    public const ORDER_VLADIMIR_PETROV_00003 = 'order_vladimir_petrov_00003';
    public const ORDER_MARTA_NOWAK_00004 = 'order_marta_nowak_00004';
    public const ORDER_LEA_GIRARD_00005 = 'order_lea_girard_00005';
    public const ORDER_HUSSEIN_KARIMI_00006 = 'order_hussein_karimi_00006';
    public const ORDER_NATHAN_MOREAU_00007 = 'order_nathan_moreau_00007';
    public const ORDER_TOM_RICHARD_00008 = 'order_tom_richard_00008';

    public function load(ObjectManager $manager): void
    {
        $ordersData = [
            [
                'reference' => self::ORDER_EMMA_DURAND_00001,
                'userReference' => UserFixtures::REF_EMMA_DURAND,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Emma',
                'lastName' => 'Durand',
                'email' => 'emma.durand@example.com',
                'phone' => '0645678901',
                'address' => '2 quai des Chartrons',
                'city' => 'Bordeaux',
                'deliveryDate' => '2026-05-10',
                'deliveryTime' => '19:30:00',
                'peopleCount' => 4,
                'menuPrice' => 89.90,
                'deliveryPrice' => 5.00,
                'discount' => 0.00,
                'totalPrice' => 94.90,
                'status' => 'DELIVERED',
                'createdAt' => '2026-05-01 10:12:00',
                'hasBorrowedMaterial' => false,
                'distanceKm' => 0.00,
            ],
            [
                'reference' => self::ORDER_SARAH_PETIT_00002,
                'userReference' => UserFixtures::REF_SARAH_PETIT,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Sarah',
                'lastName' => 'Petit',
                'email' => 'sarah.petit@yahoo.fr',
                'phone' => '0611122233',
                'address' => '6 rue du Professeur Bergonié',
                'city' => 'Pessac',
                'deliveryDate' => '2026-05-12',
                'deliveryTime' => '20:00:00',
                'peopleCount' => 6,
                'menuPrice' => 134.85,
                'deliveryPrice' => 7.95,
                'discount' => 13.48,
                'totalPrice' => 129.32,
                'status' => 'PENDING',
                'createdAt' => '2026-05-02 14:22:00',
                'hasBorrowedMaterial' => true,
                'distanceKm' => 5.00,
            ],
            [
                'reference' => self::ORDER_VLADIMIR_PETROV_00003,
                'userReference' => UserFixtures::REF_VLADIMIR_PETROV,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Vladimir',
                'lastName' => 'Petrov',
                'email' => 'vladimir.petrov@gmail.com',
                'phone' => '0678001122',
                'address' => '4 rue du Loup',
                'city' => 'Bordeaux',
                'deliveryDate' => '2026-05-14',
                'deliveryTime' => '18:45:00',
                'peopleCount' => 5,
                'menuPrice' => 112.40,
                'deliveryPrice' => 6.77,
                'discount' => 0.00,
                'totalPrice' => 119.17,
                'status' => 'COMPLETED',
                'createdAt' => '2026-05-03 09:10:00',
                'hasBorrowedMaterial' => false,
                'distanceKm' => 3.00,
            ],
            [
                'reference' => self::ORDER_MARTA_NOWAK_00004,
                'userReference' => UserFixtures::REF_MARTA_NOWAK,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Marta',
                'lastName' => 'Nowak',
                'email' => 'marta.nowak@example.com',
                'phone' => '0650010203',
                'address' => '15 rue Sainte-Catherine',
                'city' => 'Bordeaux',
                'deliveryDate' => '2026-05-15',
                'deliveryTime' => '19:00:00',
                'peopleCount' => 3,
                'menuPrice' => 67.43,
                'deliveryPrice' => 5.00,
                'discount' => 0.00,
                'totalPrice' => 72.43,
                'status' => 'PENDING',
                'createdAt' => '2026-05-04 11:20:00',
                'hasBorrowedMaterial' => false,
                'distanceKm' => 1.50,
            ],
            [
                'reference' => self::ORDER_LEA_GIRARD_00005,
                'userReference' => UserFixtures::REF_LEA_GIRARD,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Léa',
                'lastName' => 'Girard',
                'email' => 'lea.girard@example.com',
                'phone' => '0651122334',
                'address' => '22 avenue de la Libération',
                'city' => 'Talence',
                'deliveryDate' => '2026-05-16',
                'deliveryTime' => '20:15:00',
                'peopleCount' => 4,
                'menuPrice' => 89.90,
                'deliveryPrice' => 6.12,
                'discount' => 0.00,
                'totalPrice' => 96.02,
                'status' => 'PENDING',
                'createdAt' => '2026-05-05 09:45:00',
                'hasBorrowedMaterial' => false,
                'distanceKm' => 2.40,
            ],
            [
                'reference' => self::ORDER_HUSSEIN_KARIMI_00006,
                'userReference' => UserFixtures::REF_HUSSEIN_KARIMI,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Hussein',
                'lastName' => 'Karimi',
                'email' => 'hussein.karimi@example.com',
                'phone' => '0662233445',
                'address' => '8 rue Judaïque',
                'city' => 'Bordeaux',
                'deliveryDate' => '2026-05-17',
                'deliveryTime' => '18:30:00',
                'peopleCount' => 2,
                'menuPrice' => 44.95,
                'deliveryPrice' => 5.00,
                'discount' => 0.00,
                'totalPrice' => 49.95,
                'status' => 'PENDING',
                'createdAt' => '2026-05-06 13:10:00',
                'hasBorrowedMaterial' => false,
                'distanceKm' => 1.10,
            ],
            [
                'reference' => self::ORDER_NATHAN_MOREAU_00007,
                'userReference' => UserFixtures::REF_NATHAN_MOREAU,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Nathan',
                'lastName' => 'Moreau',
                'email' => 'nathan.moreau@example.com',
                'phone' => '0673344556',
                'address' => '12 rue Fondaudège',
                'city' => 'Bordeaux',
                'deliveryDate' => '2026-05-18',
                'deliveryTime' => '19:45:00',
                'peopleCount' => 5,
                'menuPrice' => 112.40,
                'deliveryPrice' => 5.85,
                'discount' => 0.00,
                'totalPrice' => 118.25,
                'status' => 'PENDING',
                'createdAt' => '2026-05-07 16:05:00',
                'hasBorrowedMaterial' => true,
                'distanceKm' => 2.80,
            ],
            [
                'reference' => self::ORDER_TOM_RICHARD_00008,
                'userReference' => UserFixtures::REF_TOM_RICHARD,
                'menuReference' => MenuFixtures::MENU_NOEL_PRESTIGE,
                'firstName' => 'Tom',
                'lastName' => 'Richard',
                'email' => 'tom.richard@example.com',
                'phone' => '0684455667',
                'address' => '5 place Pey-Berland',
                'city' => 'Bordeaux',
                'deliveryDate' => '2026-05-19',
                'deliveryTime' => '20:30:00',
                'peopleCount' => 3,
                'menuPrice' => 67.43,
                'deliveryPrice' => 5.00,
                'discount' => 6.74,
                'totalPrice' => 65.69,
                'status' => 'PENDING',
                'createdAt' => '2026-05-08 12:40:00',
                'hasBorrowedMaterial' => false,
                'distanceKm' => 0.90,
            ],
        ];

        foreach ($ordersData as $data) {

            $order = new Order();

            $order->setMenu($this->getReference($data['menuReference'], Menu::class));
            $order->setUser($this->getReference($data['userReference'], User::class));

            $order->setFirstName($data['firstName']);
            $order->setLastName($data['lastName']);
            $order->setEmail($data['email']);
            $order->setPhone($data['phone']);
            $order->setAddress($data['address']);
            $order->setCity($data['city']);

            $order->setDeliveryDate(new DateTimeImmutable($data['deliveryDate']));
            $order->setDeliveryTime(new DateTimeImmutable($data['deliveryTime']));

            $order->setPeopleCount($data['peopleCount']);
            $order->setMenuPrice($data['menuPrice']);
            $order->setDeliveryPrice($data['deliveryPrice']);
            $order->setDiscount($data['discount']);
            $order->setTotalPrice($data['totalPrice']);
            $order->setStatus($data['status']);
            $order->setCreatedAt(new DateTimeImmutable($data['createdAt']));
            $order->setHasBorrowedMaterial($data['hasBorrowedMaterial']);
            $order->setDistanceKm($data['distanceKm']);

            $manager->persist($order);

            $this->addReference($data['reference'], $order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            MenuFixtures::class
        ];
    }
}
