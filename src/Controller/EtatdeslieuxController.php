<?php

namespace App\Controller;

use App\Entity\EtatDesLieux;
use App\Repository\EtatDesLieuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EtatDesLieuxFormType;


class EtatdeslieuxController extends AbstractController
{
    #[Route('/etatdeslieux', name: 'app_etatdeslieux')]
    public function index(EtatDesLieuxRepository $etatdeslieuxRepository): Response
    {
        $etatdeslieux = $etatdeslieuxRepository->findAll();
        return $this->render('etatdeslieux/index.html.twig', [
        'etatdeslieux' => $etatdeslieux,
        ]);
    }


    // CREATE
    #[Route('/etatdeslieux/create', name: 'app_etatdeslieux_create')]
    public function creat(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $etatsdeslieux = new EtatDesLieux(); 
        $form = $this->createForm(EtatDesLieuxFormType::class, $etatsdeslieux);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager->persist($etatsdeslieux);
            $entitymanager->flush();
            $this->addFlash('success', 'Letat des lieux a ete crée');
            return $this->redirectToRoute('app_etatdeslieux'); 
        } 
        return $this->render('etatdeslieux/create.html.twig', [
            'form' => $form->createView(),
        ]); 
    }

    // EDIT
    #[Route('/etatdeslieux/{id}/edit', name: 'app_etatdeslieux_edit')]
    public function edit(Request $request, EtatDesLieux $etatdeslieux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtatDesLieuxFormType::class, $etatdeslieux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etatdeslieux);
            $entityManager->flush();
            $this->addFlash('success', 'Modification validé !');
            return $this->redirectToRoute('app_etatdeslieux');
        }

        return $this->render('etatdeslieux/edit.html.twig', [
            'etatdeslieux' => $etatdeslieux,
            'form' => $form->createView(),
        ]);
    }


    // DELETE
    #[Route('/etatdeslieux/{id}/delete', name: 'app_etatdeslieux_delete', methods: ['POST'])]
    public function delete(Request $request, EtatDesLieux $etatdeslieux, EntityManagerInterface $entityManager): Response 
    {
        if($this->isCsrfTokenValid('delete'.$etatdeslieux->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etatdeslieux);
            $entityManager->flush();
            $this->addFlash('success', 'Letat des lieux a été supprimé avec succès ! ');
        }
        return $this->redirectToRoute('app_etatdeslieux');
    }

}
