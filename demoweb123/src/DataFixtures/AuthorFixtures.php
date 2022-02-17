<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $author = new Author;
            $author->setAddress("Ha Noi");
            $author->setName("Author $i");
            $author->setBirthday(\DateTime::createFromFormat('Y/m/d','1995/07/15'));
            $author->setImage("https://www.storey-lines.com/wp-content/uploads/2013/04/Writer-V-Author-Whats-The-Difference.jpg");
            $manager->persist($author);
        }
        $manager->flush();
    }
}
