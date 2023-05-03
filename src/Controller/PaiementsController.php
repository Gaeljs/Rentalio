<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementsController extends AbstractController
{
    #[Route('/paiements', name: 'paiements')]
    public function index(): Response
    {
        return new Response('Hello Paiements');
    }
}
