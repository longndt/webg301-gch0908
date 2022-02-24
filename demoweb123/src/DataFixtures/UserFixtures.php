<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        //tạo tài khoản demo cho role Admin
        $user = new User;
        $user->setUsername("admin");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $manager->persist($user);

        //tạo tài khoản demo cho role User
        $user = new User;
        $user->setUsername("user");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $manager->persist($user);

        //tạo tài khoản demo cho role Manager
        $user = new User;
        $user->setUsername("manager");
        $user->setRoles(['ROLE_MANAGER']);
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $manager->persist($user);

        $manager->flush();
    }
}
