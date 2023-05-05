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
    #[Route('/paiements', name: 'app_paiements')]
    public function index(PaiementRepository $paiementRepository): Response
    {
        // on recup les infos du paiements et on affiche par date inversé
        $paiements = $paiementRepository->findBy([], ['date' => 'DESC']);
        
        // on recup les infos du locataires
        $locataires = []; 
        foreach ($paiements as $paiement) {
            $contrat = $paiement->getContratId();
            $locataire = $contrat->getLocataireId();
            $nomLocataire = $locataire->getNom();
            $locataires[$paiement->getId()] = $nomLocataire;
        }

        return $this->render('paiements/index.html.twig', [
            'paiements' => $paiements,
            'locataires' => $locataires,
        ]);
    }

    // CREATE
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

    // EDIT 
    #[Route('/paiements/{id}/edit', name: 'app_paiements_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, PaiementRepository $paiementRepository, Paiement $paiement, ): Response
    {

        $form = $this->createForm(PaiementFormType::class, $paiement);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($paiement);
            $entityManager->flush();
            $this->addFlash('success', 'le paiement a bien été modifié');
            return $this->redirectToRoute('app_paiements');
        }
        return $this->render('paiements/edit.html.twig', [
            'paiement' => $paiement, 
            'form' => $form->createView(),
        ]);
    }


    // DELETE
    #[Route('/paiements/{id}/delete', name: 'app_paiements_delete', methods:['POST'])]
    public function delete(EntityManagerInterface $entityManager, Paiement $paiement): Response
    {
        $entityManager->remove($paiement); 
        $entityManager->flush();

        $this->addFlash('success', 'le paiement a été supprimé');
        return $this->redirectToRoute('app_paiements');
    }
}
