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
            $book->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsfxrcUtlaLqSTTpA7N9cWKIopvRNtXngM2A&usqp=CAU");
            $manager->persist($book);
        }

        $manager->flush();
    }
}
