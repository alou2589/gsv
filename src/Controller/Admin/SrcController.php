<?php

namespace App\Controller\Admin;

use App\Entity\ServiceRegional;
use App\Form\ServiceRegionalType;
use App\Repository\AffectationRepository;
use App\Repository\ServiceRegionalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/src')]
class SrcController extends AbstractController
{
    #[Route('/', name: 'app_admin_src_index', methods: ['GET'])]
    public function index(ServiceRegionalRepository $serviceRegionalRepository): Response
    {
        return $this->render('admin/src/index.html.twig', [
            'service_regionals' => $serviceRegionalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_src_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serviceRegional = new ServiceRegional();
        $form = $this->createForm(ServiceRegionalType::class, $serviceRegional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceRegional);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_src_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/src/new.html.twig', [
            'service_regional' => $serviceRegional,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_src_show', methods: ['GET'])]
    public function show(ServiceRegional $serviceRegional, AffectationRepository $affectationRepository): Response
    {
        $srcVolontaires=$affectationRepository->srcVolontaires($serviceRegional);
        return $this->render('admin/src/show.html.twig', [
            'service_regional' => $serviceRegional,
            'srcVolontaires'=>$srcVolontaires,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_src_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceRegional $serviceRegional, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceRegionalType::class, $serviceRegional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_src_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/src/edit.html.twig', [
            'service_regional' => $serviceRegional,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_src_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceRegional $serviceRegional, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceRegional->getId(), $request->request->get('_token'))) {
            $entityManager->remove($serviceRegional);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_src_index', [], Response::HTTP_SEE_OTHER);
    }
}
