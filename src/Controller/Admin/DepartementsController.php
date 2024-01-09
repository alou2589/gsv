<?php

namespace App\Controller\Admin;

use App\Entity\Departements;
use App\Form\DepartementsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use App\Repository\DepartementsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/departements')]
class DepartementsController extends AbstractController
{
    #[Route('/', name: 'app_admin_departements_index', methods: ['GET'])]
    public function index(DepartementsRepository $departementsRepository): Response
    {
        return $this->render('admin/departements/index.html.twig', [
            'departements' => $departementsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_departements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $departement = new Departements();
        $form = $this->createForm(DepartementsType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($departement);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_departements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/departements/new.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_departements_show', methods: ['GET'])]
    public function show(Departements $departement, AffectationRepository $affectationRepository): Response
    {
        $departementVolontaire=$affectationRepository->departementVolontaires($departement);
        return $this->render('admin/departements/show.html.twig', [
            'departement' => $departement,
            'departementVolontaire'=>$departementVolontaire
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_departements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departements $departement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepartementsType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_departements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/departements/edit.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_departements_delete', methods: ['POST'])]
    public function delete(Request $request, Departements $departement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($departement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_departements_index', [], Response::HTTP_SEE_OTHER);
    }
}
