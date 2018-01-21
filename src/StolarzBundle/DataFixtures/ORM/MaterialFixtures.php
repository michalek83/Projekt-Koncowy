<?php
namespace StolarzBundle\DataFixtures\ORM;

use StolarzBundle\Entity\Material;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MaterialFixtures extends Fixture
{
    public function load(ObjectManager $manager)
        {
        // create 20 products! Bam!
            for ($i = 1; $i <= 20; $i++) {
                $material = new Material();
                $material->setName('Materiał ' . $i);
                $material->setDescription('Uwaga nr ' . $i);

                $manager->persist($material);
            }

        $manager->flush();
    }
}