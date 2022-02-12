<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $movie = new Movie;
            $movie->setName("Movie $i");
            $movie->setImage("https://www.orange.nsw.gov.au/wp-content/uploads/2021/12/Fall-Movie-Review.jpg");
            $movie->setYear(rand(2010,2020));
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
