<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++) {
            $category = new Category;
            $category->setName("Class $i");
            $category->setDescription("");
            $manager->persist($category);
        }

        $manager->flush();
    }
}
