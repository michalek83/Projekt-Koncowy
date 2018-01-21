<?php
namespace StolarzBundle\DataFixtures\ORM;

use StolarzBundle\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
        {
        // create 20 products! Bam!
            for ($i = 1; $i <= 20; $i++) {
                $customer = new Customer();
                $customer->setName('Obrzeże ' . $i);
                $customer->setDescription('Uwaga nr ' . $i);
                $customer->setAddress('Miasto' . $i);

                $manager->persist($customer);
            }

        $manager->flush();
    }
}