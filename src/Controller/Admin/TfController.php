<?php

namespace App\Controller\Admin;

use App\Entity\TypeFichier;
use App\Form\TypeFichierType;
use App\Repository\TypeFichierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tf')]
class TfController extends AbstractController
{
    #[Route('/', name: 'app_admin_tf_index', methods: ['GET'])]
    public function index(TypeFichierRepository $typeFichierRepository): Response
    {
        return $this->render('admin/tf/index.html.twig', [
            'type_fichiers' => $typeFichierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_tf_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeFichier = new TypeFichier();
        $form = $this->createForm(TypeFichierType::class, $typeFichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeFichier);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tf/new.html.twig', [
            'type_fichier' => $typeFichier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_tf_show', methods: ['GET'])]
    public function show(TypeFichier $typeFichier): Response
    {
        return $this->render('admin/tf/show.html.twig', [
            'type_fichier' => $typeFichier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_tf_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeFichier $typeFichier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeFichierType::class, $typeFichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tf/edit.html.twig', [
            'type_fichier' => $typeFichier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tf_delete', methods: ['POST'])]
    public function delete(Request $request, TypeFichier $typeFichier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeFichier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeFichier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_tf_index', [], Response::HTTP_SEE_OTHER);
    }
}
