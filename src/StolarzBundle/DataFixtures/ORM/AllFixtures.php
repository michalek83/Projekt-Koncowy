<?php
namespace StolarzBundle\DataFixtures\ORM;

use StolarzBundle\Entity\Customer;
use StolarzBundle\Entity\Edge;
use StolarzBundle\Entity\Material;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AllFixtures extends Fixture
{
    public function load(ObjectManager $manager)
        {
        // create 5 customers, edges, material
            for ($i = 1; $i <= 20; $i++) {
                $customer = new Customer();
                $customer->setName('Customer nr ' . $i);
                $customer->setDescription('Description no ' . $i);
                $customer->setAddress('Address' . $i);

                $manager->persist($customer);

                $edge = new Edge();
                $edge->setName('Edge ' . $i);
                $edge->setDescription('Description no ' . $i);
                $edge->setThickness($i/10);

                $manager->persist($edge);

                $material = new Material();
                $material->setName('Material no ' . $i);
                $material->setDescription('Description no ' . $i);

                $manager->persist($material);
            }

        $manager->flush();
    }
}