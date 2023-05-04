<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaiementsControllerTest extends WebTestCase
{
    public function testPaiementsControllerExist(): void
    {
        {
            $client = static::createClient();
    
            // Remplacez '/paiements' par l'URL de la route de votre PaiementsController
            $client->request('GET', $this->generateUrl('paiements'));

            $response = $client->getResponse();
    
            // Vérifie que le code de statut HTTP est 200 (OK)
            $this->assertEquals(200, $response->getStatusCode());        
        }
    }
}