<?php

namespace App\DataFixtures;

use App\Entity\Laptop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LaptopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=100; $i++) {
            $laptop = new Laptop;
            $laptop->setName("XPS 13");
            $laptop->setBrand("Dell");
            $laptop->setImage("https://th.bing.com/th/id/OIP.BlUrznhJmOf6zUMKQJbezgHaFb?w=234&h=180&c=7&r=0&o=5&dpr=1.25&pid=1.7");
            $laptop->setDate(\DateTime::createFromFormat('Y-m-d','2022-01-10'));
            $manager->persist($laptop);
        }

        $manager->flush();
    }
}
