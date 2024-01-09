<?php

namespace App\Controller\Admin;

use App\Entity\Emargement;
use App\Form\EmargementType;
use App\Repository\EmargementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/emargement')]
class EmargementController extends AbstractController
{
    #[Route('/', name: 'app_admin_emargement_index', methods: ['GET'])]
    public function index(EmargementRepository $emargementRepository): Response
    {
        return $this->render('admin/emargement/index.html.twig', [
            'emargements' => $emargementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_emargement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emargement = new Emargement();
        $form = $this->createForm(EmargementType::class, $emargement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($emargement);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_emargement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/emargement/new.html.twig', [
            'emargement' => $emargement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_emargement_show', methods: ['GET'])]
    public function show(Emargement $emargement): Response
    {
        return $this->render('admin/emargement/show.html.twig', [
            'emargement' => $emargement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_emargement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emargement $emargement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmargementType::class, $emargement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_emargement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/emargement/edit.html.twig', [
            'emargement' => $emargement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_emargement_delete', methods: ['POST'])]
    public function delete(Request $request, Emargement $emargement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emargement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($emargement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_emargement_index', [], Response::HTTP_SEE_OTHER);
    }
}
