<?php

namespace App\Controller\Admin;

use DateTime;
use DateTimeImmutable;
use App\Entity\Emargement;
use App\Form\FPEmargementType;
use App\Entity\BilanVolontaire;
use App\Entity\FeuillePresence;
use App\Entity\EmargementSearch;
use App\Service\OpenDaysService;
use App\Form\FeuillePresenceType;
use App\Form\EmargementSearchType;
use App\Repository\EmargementRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use App\Repository\BilanVolontaireRepository;
use App\Repository\FeuillePresenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EtatTempsPresenceRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/fp')]
class FPController extends AbstractController
{
    #[Route('/', name: 'app_admin_fp_index', methods: ['GET','POST'])]
    public function index(Request $request,EmargementRepository $emargementRepository,FeuillePresenceRepository $feuillePresenceRepository): Response
    {
        return $this->render('admin/fp/index.html.twig', [
            'feuille_presences' => $feuillePresenceRepository->findAll(),
        ]);
    }
    

    #[Route('/filter', name: 'app_admin_fp_index_filter', methods: ['GET','POST'])]
    public function index_filter(Request $request,EmargementRepository $emargementRepository,FeuillePresenceRepository $feuillePresenceRepository): Response
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
            foreach ($feuillePresence->getServiceDepartemental()->getAffectations() as $affectation) {
                # code...
                $emargement=new Emargement();
                $emargement->setAffectation($affectation);
                $emargement->setFeuille($feuillePresence);
                $entityManager->persist($emargement);
                $entityManager->flush();
            }

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
        return $this->render('admin/fp/show.html.twig', [
            'feuille_presence' => $feuillePresence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_fp_edit', methods: ['GET'])]
    public function edit(Request $request, FeuillePresence $feuillePresence, EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/fp/edit.html.twig', [
            'feuille_presence' => $feuillePresence,
        ]);
    }
    
    
    #[Route('/{id}/emarger/{id_emargement}', name: 'app_admin_emarger_fp_emargement', methods: ['GET','POST'])]
    public function emarger(Request $request,OpenDaysService $openDaysService,BilanVolontaireRepository $bilanVolontaireRepository,EmargementRepository $emargementRepository,EtatTempsPresenceRepository $etatTempsPresenceRepository, FeuillePresence $feuillePresence, EntityManagerInterface $entityManager, $id_emargement): Response
    {
        $form = $this->createForm(FeuillePresenceType::class, $feuillePresence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_fp_index', [], Response::HTTP_SEE_OTHER);
        }
        $emargement=$emargementRepository->findOneBy(['feuille'=>$feuillePresence,'id'=>$id_emargement]);
        if ($this->isCsrfTokenValid('emarger'.$feuillePresence->getId(), $request->request->get('_token'))) {
            $presence=$etatTempsPresenceRepository->findOneBy(['nom_etat_tp'=>'Présent']);
            $emargement->setHeure($feuillePresence->getDateFeuille());
            $emargement->setEtatTp($presence);
            $bilanVolontaire=$bilanVolontaireRepository->findOneBy(['affectation'=>$emargement->getAffectation(),'mois'=>$emargement->getHeure()->format('F'),'annee'=>$emargement->getHeure()->format('Y')]);
            if($bilanVolontaire != null){
                if($bilanVolontaire->getNbJoursOuvrables() == 0){
                    $nbOpenDaysInMonth= $openDaysService->calculJoursFeries($emargement->getHeure()->format('m'));
                    $bilanVolontaire->setNbJoursOuvrables($nbOpenDaysInMonth);
                }
                $bilanVolontaire->setNbjourPresence($bilanVolontaire->getNbjourPresence()+1);
                $entityManager->persist($bilanVolontaire);
            }
            else{
                $bilanVolontaire=new BilanVolontaire();
                $bilanVolontaire->setAffectation($emargement->getAffectation());
                $bilanVolontaire->setMois($emargement->getHeure()->format('F'));
                $bilanVolontaire->setAnnee($emargement->getHeure()->format('Y'));
                $nbOpenDaysInMonth= $openDaysService->calculJoursFeries($emargement->getHeure()->format('m'));
                $bilanVolontaire->setNbjourPresence(1);
                $bilanVolontaire->setNbjourAbsence(0);
                $bilanVolontaire->setNbJoursOuvrables($nbOpenDaysInMonth);
                $entityManager->persist($bilanVolontaire);
            }
            $entityManager->persist($emargement);
            $entityManager->persist($feuillePresence);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_fp_show', ['id'=>$feuillePresence->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fp/fp_emargement.html.twig', [
            'feuille_presence' => $feuillePresence,
            'emargement'=>$emargement,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/fermer', name: 'app_admin_disable_fp_emargement', methods: ['POST'])]
    public function disable(Request $request,OpenDaysService $openDaysService,BilanVolontaireRepository $bilanVolontaireRepository,EmargementRepository $emargementRepository,EtatTempsPresenceRepository $etatTempsPresenceRepository, FeuillePresence $feuillePresence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('disable'.$feuillePresence->getId(), $request->request->get('_token'))) {
            
            $absence=$etatTempsPresenceRepository->findOneBy(['nom_etat_tp'=>'Absent']);
            $emargements=$emargementRepository->findBy(['feuille'=>$feuillePresence]);
            foreach ($emargements as $emargement) {
                # code...
                if ($emargement->getEtatTp() == null) {
                    # code...
                    $emargement->setEtatTp($absence);
                    $emargement->setHeure(new \DateTimeImmutable());
                    $bilanVolontaire=$bilanVolontaireRepository->findOneBy(['affectation'=>$emargement->getAffectation(),'mois'=>$emargement->getHeure()->format('F'),'annee'=>$emargement->getHeure()->format('Y')]);
                    if($bilanVolontaire){
                        if($bilanVolontaire->getNbJoursOuvrables() == 0){
                            $nbOpenDaysInMonth= $openDaysService->calculJoursFeries($emargement->getHeure()->format('m'));
                            $bilanVolontaire->setNbJoursOuvrables($nbOpenDaysInMonth);
                        }
                        $bilanVolontaire->setNbjourAbsence($bilanVolontaire->getNbjourAbsence()+1);
                        $entityManager->persist($bilanVolontaire);
                    }
                    else{
                        $bilanVolontaire=new BilanVolontaire();
                        $bilanVolontaire->setAffectation($emargement->getAffectation());
                        $bilanVolontaire->setMois($emargement->getHeure()->format('F'));
                        $bilanVolontaire->setAnnee($emargement->getHeure()->format('Y'));
                        $nbOpenDaysInMonth= $openDaysService->calculJoursFeries($emargement->getHeure()->format('m'));
                        $bilanVolontaire->setNbjourAbsence(1);
                        $bilanVolontaire->setNbjourPresence(0);
                        $bilanVolontaire->setNbJoursOuvrables($nbOpenDaysInMonth);
                        $entityManager->persist($bilanVolontaire);
                    }
                    
                    $entityManager->persist($emargement);
                    $entityManager->flush();
                }
            }
            $feuillePresence->setActive(false);
            $entityManager->persist($feuillePresence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_fp_show', ['id'=>$feuillePresence->getId()], Response::HTTP_SEE_OTHER);
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
