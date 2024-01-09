<?php

namespace App\Controller\Admin;

use App\Entity\Volontaire;
use App\Form\VolontaireType;
use App\Service\AesEncryptDecrypt;
use App\Repository\CarteProRepository;
use App\Repository\VolontaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StatutVolontaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/volontaire')]
class VolontaireController extends AbstractController
{
    #[Route('/', name: 'app_admin_volontaire_index', methods: ['GET'])]
    public function index(VolontaireRepository $volontaireRepository): Response
    {
        return $this->render('admin/volontaire/index.html.twig', [
            'volontaires' => $volontaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_volontaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $volontaire = new Volontaire();
        $form = $this->createForm(VolontaireType::class, $volontaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($volontaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_volontaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/volontaire/new.html.twig', [
            'volontaire' => $volontaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_volontaire_show', methods: ['GET'])]
    public function show(Volontaire $volontaire,AesEncryptDecrypt $aesEncryptDecrypt, StatutVolontaireRepository $statutVolontaireRepository, AffectationRepository $affectationRepository, CarteProRepository $carteProRepository): Response
    {
        $statutVolontaire=$statutVolontaireRepository->findOneBy(['volontaire'=>$volontaire->getId()]);
        $affectation=$affectationRepository->findOneBy(['volontaire_statut'=>$statutVolontaire->getId()]);
        $cartePro=$carteProRepository->findOneBy(['affectation'=>$affectation->getId()]);
        $qrCodeVolontaire=$aesEncryptDecrypt->decrypt($cartePro->getQrCodeVolontaire());

        return $this->render('admin/volontaire/show.html.twig', [
            'volontaire' => $volontaire,
            'statut_volontaire' => $statutVolontaire,
            'affectation' => $affectation,
            'carte_pro' => $cartePro,
            'qrCodeVolontaire' => $qrCodeVolontaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_volontaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Volontaire $volontaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolontaireType::class, $volontaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_volontaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/volontaire/edit.html.twig', [
            'volontaire' => $volontaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_volontaire_delete', methods: ['POST'])]
    public function delete(Request $request, Volontaire $volontaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$volontaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($volontaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_volontaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
