<?php

namespace App\Controller\Admin;

use App\Entity\TypeContrat;
use App\Form\TypeContratType;
use App\Repository\TypeContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tc')]
class TcController extends AbstractController
{
    #[Route('/', name: 'app_admin_tc_index', methods: ['GET'])]
    public function index(TypeContratRepository $typeContratRepository): Response
    {
        return $this->render('admin/tc/index.html.twig', [
            'type_contrats' => $typeContratRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_tc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeContrat = new TypeContrat();
        $form = $this->createForm(TypeContratType::class, $typeContrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeContrat);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tc/new.html.twig', [
            'type_contrat' => $typeContrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_tc_show', methods: ['GET'])]
    public function show(TypeContrat $typeContrat): Response
    {
        return $this->render('admin/tc/show.html.twig', [
            'type_contrat' => $typeContrat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_tc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeContrat $typeContrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeContratType::class, $typeContrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tc/edit.html.twig', [
            'type_contrat' => $typeContrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tc_delete', methods: ['GET','POST'])]
    public function delete(Request $request, TypeContrat $typeContrat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeContrat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeContrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_tc_index', [], Response::HTTP_SEE_OTHER);
    }
}
