<?php
namespace StolarzBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use StolarzBundle\Entity\Customer;
use StolarzBundle\Entity\Edge;
use StolarzBundle\Entity\Element;
use StolarzBundle\Entity\Material;
use StolarzBundle\Entity\Order;

class AllFixtures extends Fixture
{
    public function load(ObjectManager $manager)
        {
        // create 5 customers, edges, material
            for ($i = 1; $i <= 20; $i++) {
                $customer = new Customer();
                $customer->setName('CustomerName nr ' . $i);
                $customer->setDescription('Description no ' . $i);
                $customer->setAddress('Address' . $i);
                if(0 == $i%2) {
                    $customer->setEmailAddress('michalgorniak@o2.pl');
                }else{
                    $customer->setEmailAddress('michalek_18@wp.pl');
                }

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

                $order = new Order();
                $order->setCustomer($customer);

                for ($j = 1; $j < 10; $j++){
                    $element = new Element();
                    $element->setMaterial($material);
                    $element->setOrder($order);
                    $element->setEdgeLenght1($edge);
                    $element->setEdgeLenght2($edge);
                    $element->setEdgeWidth1($edge);
                    $element->setEdgeWidth2($edge);
                    $element->setQuantity(10 + $j);
                    $element->setLenght(100 + $j);
                    $element->setWidth(200 + $i);
                    if(0 == $j%2) {
                        $element->setRotatable(true);
                    }else{
                        $element->setRotatable(false);
                    }
                    $manager->persist($element);
                }

                $manager->persist($order);
            }

        $manager->flush();
    }
}