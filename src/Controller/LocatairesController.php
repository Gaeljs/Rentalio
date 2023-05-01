<?php

namespace App\Controller;

use App\Entity\Locataire;
use App\Repository\LocataireRepository;
use App\Form\LocataireFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LocatairesController extends AbstractController
{
    #[Route('/locataires', name: 'app_locataires')]
    public function index(LocataireRepository $locataireRepository): Response
    {
        $locataires = $locataireRepository->findAll();
        return $this->render('locataires/index.html.twig', [
            'locataires' => $locataires
        ]);
    }

    // CREATE locataire 
    #[Route('/locataires/create', name: 'app_locataires_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $locataire = new Locataire();
        $form = $this->createForm(LocataireFormType::class, $locataire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($locataire);
            $entityManager->flush();
            $this->addFlash('success', 'Le locataire a été crée avec succès');
            return $this->redirectToRoute('app_locataires');
        }
        return $this->render('locataires/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // UPDATE Locataire
    #[Route('/locataires/{id}/edit', name: 'app_locataires_edit')]
    public function edit(Request $request, Locataire $locataire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocataireFormType::class, $locataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($locataire);
            $entityManager->flush();
            $this->addFlash('success', 'Modification validé !');
            return $this->redirectToRoute('app_locataires');
        }

        return $this->render('locataires/edit.html.twig', [
            'locataire' => $locataire,
            'form' => $form->createView(),
        ]);
    }

    // DELETE Locataire
    #[Route('/locataires/{id}/delete', name: 'app_locataires_delete', methods: ['POST'])]
    public function delete(Request $request, Locataire $locataire, EntityManagerInterface $entityManager): Response 
    {
        if($this->isCsrfTokenValid('delete'.$locataire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($locataire);
            $entityManager->flush();
            $this->addFlash('success', 'Le Locataire a été supprimé avec succès ! ');
        }
        return $this->redirectToRoute('app_locataires');
    }

}
