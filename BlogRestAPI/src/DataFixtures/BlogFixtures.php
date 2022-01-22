<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $blog = new Blog;
            $blog->setTitle("Blog $i");
            $blog->setAuthor("Viet Hung");
            $blog->setContent("This is my new blog about IT");
            $blog->setDate(\DateTime::createFromFormat('Y-m-d','2022-03-02'));
            $manager->persist($blog);
        }
        $manager->flush();
    }
}
