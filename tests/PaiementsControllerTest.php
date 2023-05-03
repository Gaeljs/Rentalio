<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaiementsControllerTest extends WebTestCase
{
    public function testPaiementsControllerExist(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/paiements');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
    }
}