<?php

namespace StolarzBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MaterialControllerTest extends WebTestCase
{
    public function testMainmaterial()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mainMaterial');
    }

    public function testCreatematerial()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createMaterial');
    }

    public function testDeletematerial()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteMaterial');
    }

}
