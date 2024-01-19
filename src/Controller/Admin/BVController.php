<?php

namespace App\Controller\Admin;

use App\Entity\BulletinVolontaire;
use App\Form\BulletinVolontaireType;
use App\Repository\BilanVolontaireRepository;
use App\Repository\BulletinVolontaireRepository;
use App\Repository\EmargementRepository;
use App\Repository\FeuillePresenceRepository;
use App\Repository\JustificationAbsenceRepository;
use App\Service\OpenDaysService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/bulletin')]
class BVController extends AbstractController
{
    #[Route('/', name: 'app_admin_bv_index', methods: ['GET'])]
    public function index(BulletinVolontaireRepository $bulletinVolontaireRepository): Response
    {
        return $this->render('admin/bv/index.html.twig', [
            'bulletin_volontaires' => $bulletinVolontaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_bv_new', methods: ['GET', 'POST'])]
    public function new(Request $request,OpenDaysService $openDaysService,JustificationAbsenceRepository $justificationAbsenceRepository,FeuillePresenceRepository $feuillePresenceRepository ,BilanVolontaireRepository $bilanVolontaireRepository, EntityManagerInterface $entityManager): Response
    {
        $bulletinVolontaire = new BulletinVolontaire();
        $absences_justifiées=$justificationAbsenceRepository->findAll();
        $form = $this->createForm(BulletinVolontaireType::class, $bulletinVolontaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //$nbOpenDaysInMonth= $openDaysService->calculJoursFeries($bulletinVolontaire->getBilanVolontaire()->getMois());
            $nbFeuilles=$feuillePresenceRepository->findByMonth($bulletinVolontaire->getBilanVolontaire()->getMois());
            $presents=$bulletinVolontaire->getBilanVolontaire()->getNbjourPresence();
            $absents=$bulletinVolontaire->getBilanVolontaire()->getNbjourAbsence();
            //$nbOpenDaysInMonth=;
            $bulletinVolontaire->setPaiePresence($presents*3333);
            $bulletinVolontaire->setPaieAbsence($absents*3333);
            $bulletinVolontaire->setPaieAbsencesJustifiees(3333*count($absences_justifiées));
            if($absents>=0 && $absents<=7){
                $bulletinVolontaire->setForfait(0);
                $paieTotal=$bulletinVolontaire->getPaiePresence()+$bulletinVolontaire->getForfait()+$bulletinVolontaire->getPaieAbsencesJustifiees();
            
                $bulletinVolontaire->setTotalPaie($paieTotal);
                $entityManager->flush();
            } 
            elseif($absents>=8 && $absents<=15){
                $bulletinVolontaire->setForfait((100000-(3333*count($nbFeuilles)))/3);
                $paieTotal=$bulletinVolontaire->getPaiePresence()+$bulletinVolontaire->getForfait()+$bulletinVolontaire->getPaieAbsencesJustifiees();
            
                $bulletinVolontaire->setTotalPaie($paieTotal);
                $entityManager->flush();
            } 
            elseif($absents>=15 && $absents<24){
                $bulletinVolontaire->setForfait((100000-(3333*count($nbFeuilles)))*2/3);
                $paieTotal=$bulletinVolontaire->getPaiePresence()+$bulletinVolontaire->getForfait()+$bulletinVolontaire->getPaieAbsencesJustifiees();
            
                $bulletinVolontaire->setTotalPaie($paieTotal);
                $entityManager->flush();
            }
            else{
                $bulletinVolontaire->setForfait(100000-(3333*count($nbFeuilles)));
                $paieTotal=$bulletinVolontaire->getPaiePresence()+$bulletinVolontaire->getForfait()-$bulletinVolontaire->getPaieAbsence()+$bulletinVolontaire->getPaieAbsencesJustifiees();
            
                $bulletinVolontaire->setTotalPaie($paieTotal);
                $entityManager->flush();
            }
            $entityManager->persist($bulletinVolontaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_bv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/bv/new.html.twig', [
            'bulletin_volontaire' => $bulletinVolontaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_bv_show', methods: ['GET'])]
    public function show(BulletinVolontaire $bulletinVolontaire, JustificationAbsenceRepository $justificationAbsenceRepository): Response
    {
        return $this->render('admin/bv/show.html.twig', [
            'bulletin_volontaire' => $bulletinVolontaire,
            'absences_justifiées'=>$justificationAbsenceRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_bv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BulletinVolontaire $bulletinVolontaire, OpenDaysService $openDaysService,EmargementRepository $emargementReository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BulletinVolontaireType::class, $bulletinVolontaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($bulletinVolontaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_bv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/bv/edit.html.twig', [
            'bulletin_volontaire' => $bulletinVolontaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bv_delete', methods: ['POST'])]
    public function delete(Request $request, BulletinVolontaire $bulletinVolontaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bulletinVolontaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bulletinVolontaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_bv_index', [], Response::HTTP_SEE_OTHER);
    }
}
