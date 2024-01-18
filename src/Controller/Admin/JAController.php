<?php

namespace App\Controller\Admin;

use App\Entity\JustificationAbsence;
use App\Form\JustificationAbsenceType;
use App\Repository\EmargementRepository;
use App\Repository\JustificationAbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ja')]
class JAController extends AbstractController
{
    #[Route('/', name: 'app_admin_ja_index', methods: ['GET'])]
    public function index(JustificationAbsenceRepository $justificationAbsenceRepository): Response
    {
        return $this->render('admin/ja/index.html.twig', [
            'justification_absences' => $justificationAbsenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_ja_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EmargementRepository $emargementRepository,EntityManagerInterface $entityManager): Response
    {
        $justificationAbsence = new JustificationAbsence();
        $form = $this->createForm(JustificationAbsenceType::class, $justificationAbsence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (in_array($justificationAbsence->getAffectation(),$emargementRepository->listeAbsence($justificationAbsence->getDateDebut(),$justificationAbsence->getDateFin()))) {
                $entityManager->persist($justificationAbsence);
                $entityManager->flush();
                $this->addFlash('success','Upload du justificatif réussi');
                return $this->redirectToRoute('app_admin_ja_index', [], Response::HTTP_SEE_OTHER);
            }
            else {
                $this->addFlash('error','Erreur Upload du justificatif');
                return $this->redirectToRoute('app_admin_ja_index', [], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->render('admin/ja/new.html.twig', [
            'justification_absence' => $justificationAbsence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ja_show', methods: ['GET'])]
    public function show(JustificationAbsence $justificationAbsence): Response
    {
        return $this->render('admin/ja/show.html.twig', [
            'justification_absence' => $justificationAbsence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_ja_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JustificationAbsence $justificationAbsence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JustificationAbsenceType::class, $justificationAbsence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_ja_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/ja/edit.html.twig', [
            'justification_absence' => $justificationAbsence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ja_delete', methods: ['POST'])]
    public function delete(Request $request, JustificationAbsence $justificationAbsence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$justificationAbsence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($justificationAbsence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_ja_index', [], Response::HTTP_SEE_OTHER);
    }
}
