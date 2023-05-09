<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Paiement;
use App\Repository\PaiementRepository;
use App\Form\ContratFormType;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContratsController extends AbstractController
{
    #[Route('/contrats', name: 'app_contrats')]
    public function index(ContratRepository $contratRepository): Response
    {

        $contrats = $contratRepository->findAll();
        $soldesById = $contratRepository->getSoldesById();

        return $this->render('contrats/index.html.twig', [
            'contrats' => $contrats,
            'soldes' => $soldesById,
        ]);
    }

    // CREATE Contrat
    #[Route('/contrats/create', name: 'app_contrats_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratFormType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contrat);
            $entityManager->flush();
            return $this->redirectToRoute('app_contrats');
        }

        return $this->render('contrats/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // Edit Contrat
    #[Route('/contrats/{id}/edit', name: 'app_contrats_edit')]
    public function edit(Request $request, Contrat $contrat, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ContratFormType::class, $contrat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contrat);
            $entityManager->flush(); 
            $this->addFlash('succcess', 'Le contrat a bien été modifié');
            return $this->redirectToRoute('app_contrats');
        }

        return $this->render('contrats/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form->createView(), 
        ]);
    }


    // DELETE Contrat 
    #[Route('/contrats/{id}/delete', name: 'app_contrats_delete')]
    public function delete(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contrat);
            $entityManager->flush();
            $this->addFlash('Success', 'le contrat a bien été supprimé');
        }

        return $this->redirectToRoute('app_contrats');
        
    }











    
}
