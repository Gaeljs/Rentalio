<?php

namespace App\Controller;

use App\Entity\Logement;
use App\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LogementFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogementsController extends AbstractController
{
    #[Route('/logements', name: 'app_logements')]
    public function index(LogementRepository $logementRepository): Response
    {
        $logements = $logementRepository->findAll();
        $isGestion = false;


        return $this->render('logements/index.html.twig', [
            'logements' => $logements,
        ]);
    }

    // CREATE Logement
    #[Route('/logements/create', name: 'app_logements_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $logement = new Logement();
        $form = $this->createForm(LogementFormType::class, $logement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // recup l'agence connecté
            $agence = $this->getUser();
            // Attribution de l'id de l'agence au logement
            $logement->setAgenceId($agence);

            $entityManager->persist($logement);
            $entityManager->flush();
            $this->addFlash('success', 'le logement a bien été crée !');
            return $this->redirectToRoute('app_logements');
        }
        return $this->render('logements/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // UPDATE Logement
    #[Route('/logements/{id}/edit', name: 'app_logements_edit', methods:['GET', 'POST'])]
    public function edit(Logement $logement, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LogementFormType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le logement a été modifié avec succès !'); 
            return $this->redirectToRoute('app_logements');
        } 
        return $this->render('logements/edit.html.twig', [
            'logement' => $logement, 
            'form' => $form->createView(),
        ]);

    }

    // DELETE Logement
    #[Route('/logements/{id}/delete', name: 'app_logements_delete', methods:['POST'])]
    public function delete(Logement $logement, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($logement);
        $entityManager->flush();

        $this->addFlash('success', 'Le logement a bien été supprimé !');
        return $this->redirectToRoute('app_logements');
    }
}
