<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const REF_JOSE_MARTINEZ = 'user_jose_martinez';
    public const REF_JOSETTE_DUPONT = 'user_josette_dupont';
    public const REF_LUCAS_BERNARD = 'user_lucas_bernard';
    public const REF_EMMA_DURAND = 'user_emma_durand';
    public const REF_NATHAN_MOREAU = 'user_nathan_moreau';
    public const REF_LEA_GIRARD = 'user_lea_girard';
    public const REF_HUSSEIN_KARIMI = 'user_hussein_karimi';
    public const REF_MARTA_NOWAK = 'user_marta_nowak';
    public const REF_VLADIMIR_PETROV = 'user_vladimir_petrov';
    public const REF_CLARA_ROBERT = 'user_clara_robert';
    public const REF_TOM_RICHARD = 'user_tom_richard';
    public const REF_SARAH_PETIT = 'user_sarah_petit';

    public const ROLE_ADMIN = ['ROLE_ADMIN'];
    public const ROLE_EMPLOYEE = ['ROLE_EMPLOYEE'];
    public const ROLE_USER = ['ROLE_USER'];

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUsersData() as $data) {
            $user = $this->createUser($data);

            $manager->persist($user);
            $this->addReference($data['reference'], $user);
        }

        $manager->flush();
    }

    private function createUser(array $data): User
    {
        $user = new User();

        $user->setEmail($data['email']);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $data['password'])
        );
        
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPhone($data['phone']);
        $user->setAddress($data['address']);
        $user->setCity($data['city']);
        $user->setRoles($data['role']);
        $user->setIsActive($data['isActive']);
        $user->setCreatedAt(new DateTimeImmutable($data['createdAt']));

        return $user;
    }

    private function getUsersData(): array
    {
        return [
            [
                'reference' => self::REF_JOSE_MARTINEZ,
                'email' => 'jose@example.com',
                'password' => 'password123',
                'firstName' => 'José',
                'lastName' => 'Martinez',
                'phone' => '0612345678',
                'address' => '12 rue Sainte-Catherine',
                'city' => 'Bordeaux',
                'role' => self::ROLE_ADMIN,
                'isActive' => true,
                'createdAt' => '2026-04-01 09:00:00',
            ],
            [
                'reference' => self::REF_JOSETTE_DUPONT,
                'email' => 'josette@example.com',
                'password' => 'password123',
                'firstName' => 'Josette',
                'lastName' => 'Dupont',
                'phone' => '0623456789',
                'address' => '5 cours de l’Intendance',
                'city' => 'Bordeaux',
                'role' => self::ROLE_EMPLOYEE,
                'isActive' => true,
                'createdAt' => '2026-04-02 10:15:00',
            ],
            [
                'reference' => self::REF_LUCAS_BERNARD,
                'email' => 'lucas.bernard@example.com',
                'password' => 'password123',
                'firstName' => 'Lucas',
                'lastName' => 'Bernard',
                'phone' => '0634567890',
                'address' => '18 rue Judaïque',
                'city' => 'Bordeaux',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-03 11:20:00',
            ],
            [
                'reference' => self::REF_EMMA_DURAND,
                'email' => 'emma.durand@example.com',
                'password' => 'password123',
                'firstName' => 'Emma',
                'lastName' => 'Durand',
                'phone' => '0645678901',
                'address' => '2 quai des Chartrons',
                'city' => 'Bordeaux',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-04 14:05:00',
            ],
            [
                'reference' => self::REF_NATHAN_MOREAU,
                'email' => 'nathan.moreau@example.com',
                'password' => 'password123',
                'firstName' => 'Nathan',
                'lastName' => 'Moreau',
                'phone' => '0656789012',
                'address' => '7 rue Pasteur',
                'city' => 'Talence',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-05 16:40:00',
            ],
            [
                'reference' => self::REF_LEA_GIRARD,
                'email' => 'lea.girard@example.com',
                'password' => 'password123',
                'firstName' => 'Léa',
                'lastName' => 'Girard',
                'phone' => '0667890123',
                'address' => '25 avenue de la Libération',
                'city' => 'Bègles',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-06 08:55:00',
            ],
            [
                'reference' => self::REF_HUSSEIN_KARIMI,
                'email' => 'hussein.karimi@example.com',
                'password' => 'password123',
                'firstName' => 'Hussein',
                'lastName' => 'Karimi',
                'phone' => '0678123456',
                'address' => '9 rue de la Benauge',
                'city' => 'Bordeaux',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-07 10:30:00',
            ],
            [
                'reference' => self::REF_MARTA_NOWAK,
                'email' => 'marta.nowak@example.com',
                'password' => 'password123',
                'firstName' => 'Marta',
                'lastName' => 'Nowak',
                'phone' => '0678123499',
                'address' => '21 rue des Faures',
                'city' => 'Bordeaux',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-07 12:15:00',
            ],
            [
                'reference' => self::REF_VLADIMIR_PETROV,
                'email' => 'vladimir.petrov@example.com',
                'password' => 'password123',
                'firstName' => 'Vladimir',
                'lastName' => 'Petrov',
                'phone' => '0678001122',
                'address' => '4 rue du Loup',
                'city' => 'Bordeaux',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-07 09:20:00',
            ],
            [
                'reference' => self::REF_CLARA_ROBERT,
                'email' => 'clara.robert@example.com',
                'password' => 'password123',
                'firstName' => 'Clara',
                'lastName' => 'Robert',
                'phone' => '0689012345',
                'address' => '3 rue Voltaire',
                'city' => 'Le Bouscat',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-08 17:25:00',
            ],
            [
                'reference' => self::REF_TOM_RICHARD,
                'email' => 'tom.richard@example.com',
                'password' => 'password123',
                'firstName' => 'Tom',
                'lastName' => 'Richard',
                'phone' => '0690123456',
                'address' => '14 rue François Arago',
                'city' => 'Cenon',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-09 12:00:00',
            ],
            [
                'reference' => self::REF_SARAH_PETIT,
                'email' => 'sarah.petit@yahoo.fr',
                'password' => 'password123',
                'firstName' => 'Sarah',
                'lastName' => 'Petit',
                'phone' => '0611122233',
                'address' => '6 rue du Professeur Bergonié',
                'city' => 'Pessac',
                'role' => self::ROLE_USER,
                'isActive' => true,
                'createdAt' => '2026-04-10 15:45:00',
            ],
        ];
    }
}
