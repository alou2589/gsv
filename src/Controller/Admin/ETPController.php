<?php

namespace App\Controller\Admin;

use App\Entity\EtatTempsPresence;
use App\Form\EtatTempsPresenceType;
use App\Repository\EtatTempsPresenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/temps_presence')]
class ETPController extends AbstractController
{
    #[Route('/', name: 'app_admin_etp_index', methods: ['GET'])]
    public function index(EtatTempsPresenceRepository $etatTempsPresenceRepository): Response
    {
        return $this->render('admin/etp/index.html.twig', [
            'etat_temps_presences' => $etatTempsPresenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_etp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etatTempsPresence = new EtatTempsPresence();
        $form = $this->createForm(EtatTempsPresenceType::class, $etatTempsPresence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etatTempsPresence);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_etp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/etp/new.html.twig', [
            'etat_temps_presence' => $etatTempsPresence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_etp_show', methods: ['GET'])]
    public function show(EtatTempsPresence $etatTempsPresence): Response
    {
        return $this->render('admin/etp/show.html.twig', [
            'etat_temps_presence' => $etatTempsPresence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_etp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtatTempsPresence $etatTempsPresence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtatTempsPresenceType::class, $etatTempsPresence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_etp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/etp/edit.html.twig', [
            'etat_temps_presence' => $etatTempsPresence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_etp_delete', methods: ['POST'])]
    public function delete(Request $request, EtatTempsPresence $etatTempsPresence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etatTempsPresence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etatTempsPresence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_etp_index', [], Response::HTTP_SEE_OTHER);
    }
}
