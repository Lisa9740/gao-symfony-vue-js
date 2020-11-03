<?php

namespace App\DataFixtures;

use App\Entity\Attribution;
use App\Entity\Computer;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $computers = [];
        $customers = [];

        $today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));



        for ($y=1; $y <= 5; $y++){
            $computer = new Computer();
            $customer = new Customer();
            $attribution = new Attribution();

            $computer->setName("PC " . $y );

            $computers[] = $computer;

            $manager->persist($computer);

            $customer
                ->setFirstName('Joe' . $y)
                ->setLastName('Doe' . $y);
            $customers[] = $customer;
            $manager->persist($customer);

            $attribution
                ->setDate(new \DateTime())
                ->setCustomer($customer)
                ->setHour(8 + $y)
                ->setComputer($computer);
            $manager->persist($attribution);
        }

        $manager->flush();
    }
}
