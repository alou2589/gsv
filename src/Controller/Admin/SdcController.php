<?php

namespace App\Controller\Admin;

use App\Entity\ServiceDepartemental;
use App\Form\ServiceDepartementalType;
use App\Repository\ServiceDepartementalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sdc')]
class SdcController extends AbstractController
{
    #[Route('/', name: 'app_admin_sdc_index', methods: ['GET'])]
    public function index(ServiceDepartementalRepository $serviceDepartementalRepository): Response
    {
        return $this->render('admin/sdc/index.html.twig', [
            'service_departementals' => $serviceDepartementalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_sdc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serviceDepartemental = new ServiceDepartemental();
        $form = $this->createForm(ServiceDepartementalType::class, $serviceDepartemental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceDepartemental);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sdc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sdc/new.html.twig', [
            'service_departemental' => $serviceDepartemental,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_sdc_show', methods: ['GET'])]
    public function show(ServiceDepartemental $serviceDepartemental): Response
    {
        $sdcVolontaires=$serviceDepartemental->getAffectations();
        return $this->render('admin/sdc/show.html.twig', [
            'service_departemental' => $serviceDepartemental,
            'sdcVolontaires' => $sdcVolontaires,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_sdc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceDepartemental $serviceDepartemental, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceDepartementalType::class, $serviceDepartemental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sdc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sdc/edit.html.twig', [
            'service_departemental' => $serviceDepartemental,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sdc_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceDepartemental $serviceDepartemental, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceDepartemental->getId(), $request->request->get('_token'))) {
            $entityManager->remove($serviceDepartemental);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_sdc_index', [], Response::HTTP_SEE_OTHER);
    }
}
