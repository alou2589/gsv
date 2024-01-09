<?php

namespace App\Controller\Admin;

use App\Entity\StatutVolontaire;
use App\Form\StatutVolontaireType;
use App\Repository\StatutVolontaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sv')]
class SvController extends AbstractController
{
    #[Route('/', name: 'app_admin_sv_index', methods: ['GET'])]
    public function index(StatutVolontaireRepository $statutVolontaireRepository): Response
    {
        return $this->render('admin/sv/index.html.twig', [
            'statut_volontaires' => $statutVolontaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_sv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statutVolontaire = new StatutVolontaire();
        $form = $this->createForm(StatutVolontaireType::class, $statutVolontaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statutVolontaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sv/new.html.twig', [
            'statut_volontaire' => $statutVolontaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_sv_show', methods: ['GET'])]
    public function show(StatutVolontaire $statutVolontaire): Response
    {
        return $this->render('admin/sv/show.html.twig', [
            'statut_volontaire' => $statutVolontaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_sv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StatutVolontaire $statutVolontaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatutVolontaireType::class, $statutVolontaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sv/edit.html.twig', [
            'statut_volontaire' => $statutVolontaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sv_delete', methods: ['GET','POST'])]
    public function delete(Request $request, StatutVolontaire $statutVolontaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statutVolontaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($statutVolontaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_sv_index', [], Response::HTTP_SEE_OTHER);
    }
}
