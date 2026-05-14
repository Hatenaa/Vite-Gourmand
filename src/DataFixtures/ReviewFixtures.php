<?php

namespace App\DataFixtures;

use App\Entity\Review;
use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $reviewsData = [
            [
                'orderReference' => OrderFixtures::ORDER_MARTA_NOWAK_00004,
                'author' => UserFixtures::REF_MARTA_NOWAK,
                'note' => 3,
                'comment' => 'Le produit est correct mais j’hésite encore, j’attends de voir sur la durée.',
                'status' => 'PENDING',
                'createdAt' => '2026-04-10 14:32:00',
                'reviewAt' => null
            ],
            [
                'orderReference' => OrderFixtures::ORDER_LEA_GIRARD_00005,
                'author' => UserFixtures::REF_LEA_GIRARD,
                'note' => 4,
                'comment' => 'Bonne première impression, mais je préfère attendre avant de valider définitivement.',
                'status' => 'PENDING',
                'createdAt' => '2026-04-11 09:15:00',
                'reviewAt' => null
            ],
            [
                'orderReference' => OrderFixtures::ORDER_HUSSEIN_KARIMI_00006,
                'author' => UserFixtures::REF_HUSSEIN_KARIMI,
                'note' => 2,
                'comment' => 'Quelques problèmes rencontrés, je suis en train de tester des solutions.',
                'status' => 'PENDING',
                'createdAt' => '2026-04-12 18:47:00',
                'reviewAt' => null
            ],
            [
                'orderReference' => OrderFixtures::ORDER_NATHAN_MOREAU_00007,
                'author' => UserFixtures::REF_NATHAN_MOREAU,
                'note' => 4,
                'comment' => 'Très satisfait pour l’instant, mais j’attends confirmation sur le long terme.',
                'status' => 'PENDING',
                'createdAt' => '2026-04-13 11:05:00',
                'reviewAt' => null
            ],
            [
                'orderReference' => OrderFixtures::ORDER_TOM_RICHARD_00008,
                'author' => UserFixtures::REF_TOM_RICHARD,
                'note' => 1,
                'comment' => 'Expérience décevante jusqu’ici, je laisse en attente avant de trancher.',
                'status' => 'PENDING',
                'createdAt' => '2026-04-14 16:20:00',
                'reviewAt' => null
            ],
            [
                'orderReference' => OrderFixtures::ORDER_SARAH_PETIT_00002,
                'author' => UserFixtures::REF_SARAH_PETIT,
                'note' => 4,
                'comment' => 'Après plusieurs jours d’utilisation, je confirme que le produit est fiable et correspond à mes attentes.',
                'status' => 'COMPLETED',
                'createdAt' => '2026-04-09 10:00:00',
                'reviewAt' => '2026-04-15 13:45:00'
            ],
        ];

        foreach ($reviewsData as $data) {
            $review = new Review();

            $review->setNote($data['note']);
            $review->setComment($data['comment']);
            $review->setStatus($data['status']);
            $review->setCreatedAt(new \DateTimeImmutable($data['createdAt']));

            if ($data['reviewAt'] !== null) {
                $review->setReviewAt(new \DateTimeImmutable($data['reviewAt']));
            }

            $review->setCustomerOrder($this->getReference($data['orderReference'], Order::class));
            $review->setUser($this->getReference($data['author'], \App\Entity\User::class));

            $manager->persist($review);
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
