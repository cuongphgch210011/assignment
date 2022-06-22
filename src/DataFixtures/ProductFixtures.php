<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
     {
        for ($i=1; $i<=10; $i++) {
            $product = new Product;
            $product->setName("Product $i");
            $product->setImage('image'.$i.'.jpg');
            $product->setPrice(rand(1,5)); //1: Highest priority, 5: Lowest priority
            $product->setColor("yellow");
            
            $manager->persist($product);
        }

        $manager->flush();
    }
}