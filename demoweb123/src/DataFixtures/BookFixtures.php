<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $book = new Book;
            $book->setTitle("Programming book $i");
            $book->setQuantity(rand(5, 30));
            $book->setYear(rand(2000, 2020));
            $book->setPrice((float)(rand(100,200)));
            $book->setImage("cover.jpg");
            $manager->persist($book);
        }

        $manager->flush();
    }
}
