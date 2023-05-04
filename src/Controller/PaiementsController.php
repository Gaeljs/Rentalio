<?php

namespace App\Controller;

use App\Entity\Paiement;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PaiementFormType;
use App\Repository\PaiementRepository;

class PaiementsController extends AbstractController
{
    #[Route('/paiements', name: 'paiements')]
    public function index(PaiementRepository $paiementRepository): Response
    {
        $paiements = $paiementRepository->findAll();
        
        return $this->render('paiements/index.html.twig', [
            'paiements' => $paiements
        ]);
    }

    #[Route('/paiements/create', name: 'app_paiements_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $paiement = new Paiement();
        $form = $this->createForm(PaiementFormType::class, $paiement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($paiement);
            $entityManager->flush();
            $this->addFlash('success', 'Le paiement a été enregistré avec succès');
            return $this->redirectToRoute('app_paiements');
        }
        return $this->render('paiements/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
