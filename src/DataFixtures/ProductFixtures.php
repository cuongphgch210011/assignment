<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // for ($i = 0; $i < 5; $i++) {
        //     $product = new Product();
        //     $product 
        //         ->setName('Product '.$i)
        //         ->setDescription('This is the best shoes')
        //         ->setPrice('$' . rand(100,300))
        //         ->setCategory(rand(1,3))
        //         ->setImage('image'.$i.'.png');
        //     $manager->persist($product);
        // }


        $manager->flush();
    }
}
