<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category 
                -> setName('Nike')
                -> setDescription('This is one of the best running shoe company');
        $manager->persist($category);

        $category = new Category();
        $category 
                -> setName('Adidas')
                -> setDescription('This is one of the best running shoe company');
        $manager->persist($category);

        $category = new Category();
        $category 
                -> setName('Converse')
                -> setDescription('This is one of the youngest shoe company');
        $manager->persist($category);

        $manager->flush();
    }
}
