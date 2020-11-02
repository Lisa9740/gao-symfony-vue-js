<?php

namespace App\DataFixtures;

use App\Entity\Computer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $computers = [];


        for($i=1; $i <= 5; $i++) {
            $computer = new Computer();
            $computer->setName("PC " . $i );

            $manager->persist($computer);
            $computers[] = $computer;

            $manager->persist($computer);
        }

        $manager->flush();
    }
}
