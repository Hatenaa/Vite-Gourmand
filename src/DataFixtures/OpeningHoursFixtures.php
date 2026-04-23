<?php

namespace App\DataFixtures;

use App\Entity\OpeningHours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpeningHoursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $openingsHoursData = [
            [
                'day' => 'Lundi',
                'opening' => '09:00',
                'closing' => '18:00',
                'closed' => false
            ],
            [
                'day' => 'Mardi',
                'opening' => '09:00',
                'closing' => '18:00',
                'closed' => false
            ],
            [
                'day' => 'Mercredi',
                'opening' => '09:00',
                'closing' => '18:00',
                'closed' => false
            ],
            [
                'day' => 'Jeudi',
                'opening' => '09:00',
                'closing' => '18:00',
                'closed' => false
            ],
            [
                'day' => 'Vendredi',
                'opening' => '09:00',
                'closing' => '18:00',
                'closed' => false
            ],
            [
                'day' => 'Samedi',
                'opening' => '08:00',
                'closing' => '20:00',
                'closed' => false
            ],
            [
                'day' => 'Dimanche',
                'closed' => true
            ],
        ];

        foreach ($openingsHoursData as $data) {
            $openingsHours = new OpeningHours();

            $openingsHours->setDay($data['day']);
            $openingsHours->setIsClosed($data['closed']);

            if (!$data['closed']) {
                $openingsHours->setOpeningTime(new \DateTimeImmutable($data['opening']));
                $openingsHours->setClosingTime(new \DateTimeImmutable($data['closing']));
            }

            $manager->persist($openingsHours);
        }

        $manager->flush();
    }
}
