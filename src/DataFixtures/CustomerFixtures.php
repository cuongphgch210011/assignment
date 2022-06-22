<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++) {
            $category = new Customer;
            $category->setPhone("Category $i");
            $category->setCity("Ha Noi");
            $manager->persist($category);
            $manager->flush();
            
        }
 
        $manager->flush();
    }
}
