<?php

namespace App\DataFixtures;

use App\Document\OrderStat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class OrderStatFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private DocumentManager $documentManager)
    {

    }

    public static function getGroups(): array
    {
        return ['mongodb'];
    }

    public function load(ObjectManager $manager): void
    {
        $menusData = [
            [
                'title' => 'Noël Prestige',
                'price' => 89.00,
            ],
            [
                'title' => 'Tradition Française',
                'price' => 32.00,
            ],
            [
                'title' => 'Dolce Vita',
                'price' => 24.00,
            ],
            [
                'title' => 'Découverte',
                'price' => 28.00,
            ],
            [
                'title' => 'Végétarien',
                'price' => 24.00,
            ],
            [
                'title' => 'Matinal',
                'price' => 28.00,
            ],
            [
                'title' => 'Printemps',
                'price' => 38.00,
            ],
            [
                'title' => 'Apéritif',
                'price' => 22.00,
            ],
            [
                'title' => 'Méditerranéen',
                'price' => 24.00,
            ],
        ];


        $months = [
            new \DateTimeImmutable('2026-01-01'),
            new \DateTimeImmutable('2026-02-01'),
            new \DateTimeImmutable('2026-03-01'),
            new \DateTimeImmutable('2026-04-01'),
        ];

        foreach($months as $month){
            foreach($menusData as $data){
                $orderCount = rand(2, 15);

                $stat = new OrderStat();
                $stat->setMenuTitle($data['title']);
                $stat->setOrderCount($orderCount);
                $stat->setTotalRevenue($orderCount * $data['price']);
                $stat->setMonth($month);

                $this->documentManager->persist($stat);
            }
        }

        $this->documentManager->flush();
    }
}