<?php

namespace App\Controller\Admin;

use App\Entity\BilanSearch;
use App\Entity\BilanVolontaire;
use App\Entity\BulletinVolontaire;
use App\Form\BilanSearchType;
use App\Form\BilanVolontaireType;
use App\Repository\BilanVolontaireRepository;
use App\Repository\EmargementRepository;
use App\Service\OpenDaysService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/bilan_volontaire')]
class BilanVolontaireController extends AbstractController
{
    #[Route('/', name: 'app_admin_bilan_volontaire_index', methods: ['GET'])]
    public function index(BilanVolontaireRepository $bilanVolontaireRepository): Response
    {
        return $this->render('admin/bilan_volontaire/index.html.twig', [
            'bilan_volontaires' => $bilanVolontaireRepository->findAll(),
        ]);
    }
    #[Route('/filtre', name: 'app_admin_bilan_volontaire_index_filter', methods: ['GET', 'POST'])]
    public function index_filter(Request $request,BilanVolontaireRepository $bilanVolontaireRepository): Response
    {
        $search= new BilanSearch();
        $form=$this->createForm(BilanSearchType::class, $search);
        $form->handleRequest($request);
        $bilans=$bilanVolontaireRepository->findAllSearch($search);
        
        return $this->render('admin/bilan_volontaire/index_filter.html.twig', [
            'bilan_volontaires' => $bilanVolontaireRepository->findAllSearch($search),
            'form'=>$form->createView(),
            'bilans'=>$bilans,
        ]);
    }

    #[Route('/new', name: 'app_admin_bilan_volontaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EmargementRepository $emargementReository, OpenDaysService $openDaysService,EntityManagerInterface $entityManager): Response
    {
        $bilanVolontaire = new BilanVolontaire();
        $form = $this->createForm(BilanVolontaireType::class, $bilanVolontaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$bulletinVolontaire=new BulletinVolontaire();
            $nbOpenDaysInMonth= $openDaysService->calculJoursFeries($bilanVolontaire->getMois());
            $presents=$emargementReository->findByMonth($bilanVolontaire->getAffectation(),$bilanVolontaire->getMois(),date('Y'),"Présent");
            $absents=$emargementReository->findByMonth($bilanVolontaire->getAffectation(),$bilanVolontaire->getMois(),date('Y'),"Absent");
            
            $bilanVolontaire->setNbjourPresence(count($presents));
            //$bulletinVolontaire->setPaiePresence(count($presents)*3333);
            $bilanVolontaire->setNbjourAbsence(count($absents));
            //$bulletinVolontaire->setPaiePresence(count($absents)*3333);
            $bilanVolontaire->setNbJoursOuvrables($nbOpenDaysInMonth);
            $bilanVolontaire->setAnnee(date('Y'));
            $entityManager->persist($bilanVolontaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bilan_volontaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/bilan_volontaire/new.html.twig', [
            'bilan_volontaire' => $bilanVolontaire,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}/show', name: 'app_admin_bilan_volontaire_show', methods: ['GET'])]
    public function show(BilanVolontaire $bilanVolontaire): Response
    {
        return $this->render('admin/bilan_volontaire/show.html.twig', [
            'bilan_volontaire' => $bilanVolontaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_bilan_volontaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BilanVolontaire $bilanVolontaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BilanVolontaireType::class, $bilanVolontaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bilan_volontaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/bilan_volontaire/edit.html.twig', [
            'bilan_volontaire' => $bilanVolontaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bilan_volontaire_delete', methods: ['POST'])]
    public function delete(Request $request, BilanVolontaire $bilanVolontaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bilanVolontaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bilanVolontaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_bilan_volontaire_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/refresh', name: 'app_admin_bilan_volontaire_refresh', methods:['GET'])]
    public function refresh(){
    
    }
}
