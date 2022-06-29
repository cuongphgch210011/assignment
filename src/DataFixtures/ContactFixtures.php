<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contact = new Contact;
        $contact->setCity('Hanoi');
        $contact->setPhone('0337877040');
        $contact->setDirection('https://g.page/GreenwichVietnam?share');
        $manager->persist($contact);
        $contact = new Contact;
        $contact->setCity('Danang');
        $contact->setPhone('0358286699');
        $contact->setDirection('https://goo.gl/maps/SvT7ybQbJtPT2cod6');
        $manager->persist($contact);
        $manager->flush();
    }
}
