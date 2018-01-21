<?php
namespace StolarzBundle\DataFixtures\ORM;

use StolarzBundle\Entity\Edge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EdgeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
        {
        // create 20 products! Bam!
            for ($i = 1; $i <= 20; $i++) {
                $edge = new Edge();
                $edge->setName('Obrzeże ' . $i);
                $edge->setDescription('Uwaga nr ' . $i);
                $edge->setThickness($i);

                $manager->persist($edge);
            }

        $manager->flush();
    }
}