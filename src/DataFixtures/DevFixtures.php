<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DevFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'guest@guest.ru',
                'roles' => ['ROLE_USER'],
                'password' => 'guest@guest.ru',
                'balance' => 22,
            ],
            [
                'email' => 'admin@admin.ru',
                'roles' => ['ROLE_SUPER_ADMIN'],
                'password' => 'admin@admin.ru',
                'balance' => 42.23,
            ]
        ];

        foreach ($users as $user) {
            $userEntity = new User();
            $userEntity->setEmail($user['email']);
            $userEntity->setRoles($user['roles']);
            $userEntity->setPassword($this->passwordHasher->hashPassword($userEntity, $user['password']));
            $userEntity->setBalance($user['balance']);
            $manager->persist($userEntity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
