<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $mobile = new Mobile();
            $mobile->setName("Mobile $i");
            $mobile->setColor("Black");
            $mobile->setPrice((float)(rand(1000,1500)));
            $mobile->setDate(\DateTime::createFromFormat('Y/m/d', '2021/10/15'));
            $manager->persist($mobile);
        }
        $manager->flush();
    }
}
