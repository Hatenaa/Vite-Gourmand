<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use App\Entity\OrderContact;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderContactFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $orderContactsData = [
            [
                'orderReference' => OrderFixtures::ORDER_EMMA_DURAND_00001,
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'contactMode' => 'EMAIL',
                'reason' => 'Confirmation de la commande et vérification des détails de livraison',
                'date' => '2026-05-01 10:30:00'
            ],
            [
                'orderReference' => OrderFixtures::ORDER_EMMA_DURAND_00001,
                'employeeReference' => UserFixtures::REF_JOSE_MARTINEZ,
                'contactMode' => 'PHONE',
                'reason' => 'Modification de l’heure de livraison demandée par le client',
                'date' => '2026-05-01 11:15:00'
            ],
            [
                'orderReference' => OrderFixtures::ORDER_SARAH_PETIT_00002,
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'contactMode' => 'EMAIL',
                'reason' => 'Demande d’informations supplémentaires concernant l’adresse',
                'date' => '2026-05-02 15:00:00'
            ],
            [
                'orderReference' => OrderFixtures::ORDER_SARAH_PETIT_00002,
                'employeeReference' => UserFixtures::REF_JOSE_MARTINEZ,
                'contactMode' => 'PHONE',
                'reason' => 'Validation du nombre de personnes avant préparation',
                'date' => '2026-05-02 16:20:00'
            ],
            [
                'orderReference' => OrderFixtures::ORDER_VLADIMIR_PETROV_00003,
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'contactMode' => 'EMAIL',
                'reason' => 'Envoi du récapitulatif de commande au client',
                'date' => '2026-05-03 09:30:00'
            ],
            [
                'orderReference' => OrderFixtures::ORDER_VLADIMIR_PETROV_00003,
                'employeeReference' => UserFixtures::REF_JOSE_MARTINEZ,
                'contactMode' => 'PHONE',
                'reason' => 'Confirmation de la disponibilité du client pour la livraison',
                'date' => '2026-05-03 10:00:00'
            ],
            [
                'orderReference' => OrderFixtures::ORDER_EMMA_DURAND_00001,
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'contactMode' => 'EMAIL',
                'reason' => 'Information au client sur le départ de la livraison',
                'date' => '2026-05-01 18:00:00'
            ],
            [
                'orderReference' => OrderFixtures::ORDER_SARAH_PETIT_00002,
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'contactMode' => 'EMAIL',
                'reason' => 'Rappel des conditions de restitution du matériel prêté',
                'date' => '2026-05-02 18:45:00'
            ]
        ];

        foreach($orderContactsData as $data){
            $orderContact = new OrderContact();

            $orderContact->setCustomerOrder(
                $this->getReference($data['orderReference'], Order::class)
            );
            $orderContact->setContactedBy(
                $this->getReference($data['employeeReference'], User::class)
            );

            $orderContact->setContactMode($data['contactMode']);
            $orderContact->setReason($data['reason']);
            $orderContact->setContactedAt(new DateTimeImmutable($data['date']));

            $manager->persist($orderContact);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrderFixtures::class,
            UserFixtures::class
        ];
    }
}
