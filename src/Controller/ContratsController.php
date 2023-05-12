<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Paiement;
use App\Form\ContratFormType;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


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

    #[Route('/contrats/archive', name: 'app_contrats_archive')]
    public function archive(ContratRepository $contratRepository): Response
    {
        return $this->render('contrats/archive.html.twig', [
            'contrats' => $contratRepository->findBy(['archived' => true]),
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


    // QUITTANCE 
    #[Route('/contrats/{id}/quittance', name: 'app_contrats_quittance')]
    public function generateQuittance(Contrat $contrat)
    {
        if ($contrat->isLoyerUpToDate()) {

            // créer une quittance
            $html = $this->renderView('contrats/quittance.html.twig', ['contrat' => $contrat]);

            // config Dompdf
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');

            // instance 
            $dompdf = new Dompdf($pdfOptions);

            // injection du html a generer
            $dompdf->loadHtml($html);

            // generer le pdf
            $dompdf->render();

            // output
            $pdfOutput = $dompdf->output();

            // response symfony 
            $response = new Response($pdfOutput);

            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="quittance.pdf"');

            return $response;
        }

        throw $this->createNotFoundException('Le loyer pour le mois en cours na pas été payé');

    }



    // Sortie d'un locataire
    #[Route('/contrats/{id}/sortie', name: 'app_contrats_sortie')]
    public function sortieLocataire(Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        // verif paiement ok
        if ($contrat->isLoyerUpToDate() && $contrat->isDepotDeGarantiePaid()) {
            $solde = $contrat->getSolde();
            $contrat->setArchived(true);
            $entityManager->flush();
        
        return $this->render('contrats/bilan.html.twig', [
            'solde' => $solde,
            'contrat' => $contrat,
        ]);
        
        };
    }

}


