<?php

namespace App\Controller\Admin;

use App\Entity\Fichiers;
use App\Form\FichiersType;
use App\Repository\FichiersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/fichier')]
class FichierController extends AbstractController
{
    #[Route('/', name: 'app_admin_fichier_index', methods: ['GET'])]
    public function index(FichiersRepository $fichiersRepository): Response
    {
        return $this->render('admin/fichier/index.html.twig', [
            'fichiers' => $fichiersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_fichier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger,): Response
    {
        $fichier = new Fichiers();
        $form = $this->createForm(FichiersType::class, $fichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fichier);
            $entityManager->flush();
            
            $volontaireFile = $form->get('fichier')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($volontaireFile) {
                //$originalFilename = pathinfo($volontaireFile->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName=$fichier->getNomFichier().'-'.$fichier->getVolontaireStatut()->getMatricule();
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($fileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$volontaireFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $volontaireFile->move(
                        $this->getParameter('fichiersVolontaire_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $fichier->setFichier($newFilename);
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_admin_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fichier/new.html.twig', [
            'fichier' => $fichier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_fichier_show', methods: ['GET'])]
    public function show(Fichiers $fichier): Response
    {
        return $this->render('admin/fichier/show.html.twig', [
            'fichier' => $fichier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_fichier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fichiers $fichier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FichiersType::class, $fichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fichier/edit.html.twig', [
            'fichier' => $fichier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_fichier_delete', methods: ['GET','POST'])]
    public function delete(Request $request,EntityManagerInterface $entityManager, Fichiers $fichier,CacheManager $cacheManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichier->getId(), $request->request->get('_token'))) {
            $fichier_volontaire = $fichier->getFichier();
            $cheminFichier=$this->getParameter("fichiersVolontaire_directory").'/'.$fichier_volontaire;
            if (file_exists($cheminFichier)) { 
                unlink($cheminFichier);   
            }
            $entityManager->remove($fichier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_fichier_index', [], Response::HTTP_SEE_OTHER);
    }
}
