<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $product = new Product;
            $product->setName("Course $i");
            $product->setDescription("Product $i");
            $product->setImage("https://png.pngtree.com/png-clipart/20201209/original/pngtree-casual-shoes-png-image_5640199.jpg");
            $product->setColor("red");
            $product->setPrice("10000");
            $manager->persist($product);
        }


        $manager->flush();
    }
}
