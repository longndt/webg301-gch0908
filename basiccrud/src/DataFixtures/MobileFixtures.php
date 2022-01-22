<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=30; $i++) {
            $mobile = new Mobile;
            $mobile->setName("Mobile $i");
            $mobile->setPrice(1123.45);
            $mobile->setColor("Black");
            $mobile->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSsORBHdoBw2zCF8F5LL3CgaWOFEEg0SAs61g&usqp=CAU");
            $manager->persist($mobile);
        }
        $manager->flush();
    }
}
