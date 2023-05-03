<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaiementControllerTest extends WebTestCase
{
    public function testPaiementControllerExist(): void
    {
        $client = static::createClient();
        $client = $client->request('GET', '/paiement/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
