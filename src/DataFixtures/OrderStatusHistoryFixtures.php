<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderStatusHistoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $orderStatusHistories = [
            [
                'employeeReference' => UserFixtures::REF_JOSE_MARTINEZ,
                'orderReference' => OrderFixtures::ORDER_EMMA_DURAND_00001,
                'status' => 'COMPLETED',
                'changedAt' => '2026-05-01 10:52:00',
            ],
            [
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'orderReference' => OrderFixtures::ORDER_EMMA_DURAND_00001,
                'status' => 'PREPARING',
                'changedAt' => '2026-05-01 12:16:00',
            ],
            [
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'orderReference' => OrderFixtures::ORDER_EMMA_DURAND_00001,
                'status' => 'DELIVERING',
                'changedAt' => '2026-05-01 18:17:00',
            ],
            [
                'employeeReference' => UserFixtures::REF_JOSETTE_DUPONT,
                'orderReference' => OrderFixtures::ORDER_EMMA_DURAND_00001,
                'status' => 'DELIVERED',
                'changedAt' => '2026-05-01 19:32:00',
            ],
        ];

        foreach($orderStatusHistories as $data){

            $orderStatusHistory = new OrderStatusHistory();
            
            $orderStatusHistory->setChangedBy(
                $this->getReference($data['employeeReference'], User::class)
            );
            $orderStatusHistory->setOrderRef(
                $this->getReference($data['orderReference'], Order::class)
            );
            $orderStatusHistory->setStatus($data['status']);
            $orderStatusHistory->setChangedAt(new DateTimeImmutable($data['changedAt']));

            $manager->persist($orderStatusHistory);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            OrderFixtures::class
        ];
    }
}
