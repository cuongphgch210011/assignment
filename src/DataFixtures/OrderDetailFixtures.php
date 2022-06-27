<?php

namespace App\DataFixtures;

use App\Entity\OrderDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderDetailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $cart = new OrderDetail;
            $cart->getProduct(rand(1,5));
            $cart->setQuantity(1);
            $manager->persist($cart);
        }

        $manager->flush();
    }
}
