<?php

namespace App\Controller\Admin;

use App\Entity\Emargement;
use App\Form\FPEmargementType;
use App\Entity\FeuillePresence;
use App\Form\FeuillePresenceType;
use App\Repository\EtatTempsPresenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FeuillePresenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/fp')]
class FPController extends AbstractController
{
    #[Route('/', name: 'app_admin_fp_index', methods: ['GET'])]
    public function index(FeuillePresenceRepository $feuillePresenceRepository): Response
    {
        return $this->render('admin/fp/index.html.twig', [
            'feuille_presences' => $feuillePresenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_fp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feuillePresence = new FeuillePresence();
        $form = $this->createForm(FeuillePresenceType::class, $feuillePresence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $numeroFeuille=uniqid();
            $operateur=$this->getUser();
            
            $feuillePresence->setActive(true);
            $feuillePresence->setOperateur($operateur);
            $feuillePresence->setNumeroFeuille($numeroFeuille);
            $entityManager->persist($feuillePresence);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_fp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fp/new.html.twig', [
            'feuille_presence' => $feuillePresence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_fp_show', methods: ['GET', 'POST'])]
    public function show(FeuillePresence $feuillePresence, Request $request, EntityManagerInterface $entityManager): Response
    {
        $emargement = new Emargement();
        $form = $this->createForm(FPEmargementType::class, $emargement);
        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) {
            $emargement->setFeuille($feuillePresence);
            $entityManager->persist($emargement);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_fp_show', ['id'=>$feuillePresence->getId()], Response::HTTP_SEE_OTHER);
        }
        
        
        return $this->render('admin/fp/show.html.twig', [
            'feuille_presence' => $feuillePresence,
            'form'=>$form
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_fp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FeuillePresence $feuillePresence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FeuillePresenceType::class, $feuillePresence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_fp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fp/edit.html.twig', [
            'feuille_presence' => $feuillePresence,
            'form' => $form,
        ]);
    }
    
    
    #[Route('/{id}/fermer', name: 'app_admin_disable_fp_emargement', methods: ['POST'])]
    public function disable(Request $request,EtatTempsPresenceRepository $etatTempsPresenceRepository, FeuillePresence $feuillePresence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('disable'.$feuillePresence->getId(), $request->request->get('_token'))) {
            $emargement=new Emargement();
            $absence=$etatTempsPresenceRepository->findOneBy(['nom_etat_tp'=>'Absent']);
            $service_departemental=$feuillePresence->getServiceDepartemental();
            $affectations=$service_departemental->getAffectations();
            foreach ($affectations as $affectation) {
                $emargement->setFeuille($feuillePresence);
                $emargement->setAffectation($affectation);
                $emargement->setEtatTp($absence);
                $entityManager->persist($emargement);
                $entityManager->flush();
            }
            $feuillePresence->setActive(false);
            $entityManager->persist($feuillePresence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_fp_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'app_admin_fp_delete', methods: ['POST'])]
    public function delete(Request $request, FeuillePresence $feuillePresence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$feuillePresence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($feuillePresence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_fp_index', [], Response::HTTP_SEE_OTHER);
    }
}
