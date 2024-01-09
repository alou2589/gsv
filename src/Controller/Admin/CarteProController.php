<?php

namespace App\Controller\Admin;

use App\Entity\CartePro;
use App\Form\CarteProType;
use App\Service\QrCodeService;
use App\Service\AesEncryptDecrypt;
use App\Repository\CarteProRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/carte/pro')]
class CarteProController extends AbstractController
{
    #[Route('/', name: 'app_admin_carte_pro_index', methods: ['GET'])]
    public function index(CarteProRepository $carteProRepository): Response
    {
        return $this->render('admin/carte_pro/index.html.twig', [
            'carte_pros' => $carteProRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_carte_pro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QrCodeService $qrCodeService, AesEncryptDecrypt $aesEncryptDecrypt,EntityManagerInterface $entityManager, SluggerInterface $slugger,): Response
    {
        $cartePro = new CartePro();
        $qr_code=null;
        $form = $this->createForm(CarteProType::class, $cartePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartePro->setQrCodeVolontaire((string)$qr_code);
            $entityManager->persist($cartePro);
            $entityManager->flush();
            $qr_code=$qrCodeService->qrcode($cartePro->getAffectation()->getVolontaireStatut()->getVolontaire()->getId(), $cartePro->getId());
            
            $imageFile= $form->get('photo_volontaire')->getData();
            
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('photoVolontaire_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cartePro->setPhotoVolontaire($newFilename);
            }

            $cartePro->setQrCodeVolontaire($aesEncryptDecrypt->encrypt((string)$qr_code));
            
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/carte_pro/new.html.twig', [
            'carte_pro' => $cartePro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_carte_pro_show', methods: ['GET'])]
    public function show(CartePro $cartePro, AesEncryptDecrypt $aesEncryptDecrypt): Response
    {
        $qrCodeVolontaire=$aesEncryptDecrypt->decrypt($cartePro->getQrCodeVolontaire());
        return $this->render('admin/carte_pro/show.html.twig', [
            'carte_pro' => $cartePro,
            'qrCodeVolontaire' => $qrCodeVolontaire,
        ]);
    }
    
    #[Route('/{id}/showcode', name: 'app_admin_carte_pro_show_code', methods: ['GET'])]
    public function showcode(CartePro $cartePro,AesEncryptDecrypt $aesEncryptDecrypt)
    {
        $qrCodeVolontaire=$aesEncryptDecrypt->decrypt($cartePro->getQrCodeVolontaire());
        return $this->render('admin/carte_pro/generer_cartePro.html.twig',[
            'carte_pro'=>$cartePro,
            'qrCodeAgent'=>$qrCodeVolontaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_carte_pro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CartePro $cartePro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarteProType::class, $cartePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/carte_pro/edit.html.twig', [
            'carte_pro' => $cartePro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_carte_pro_delete', methods: ['GET','POST'])]
    public function delete(Request $request,EntityManagerInterface $entityManager, CartePro $cartePro,CacheManager $cacheManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cartePro->getId(), $request->request->get('_token'))) {
            $photo_volontaire = $cartePro->getPhotoVolontaire();
            $cheminQrCode = $this->getParameter('qrcodeVolontaire_diretory').'/'. $cartePro->getId().'.png';
            $cheminPhoto=$this->getParameter("photoVolontaire_directory").'/'.$photo_volontaire;
            if (file_exists($cheminPhoto)) {    
                unlink($cheminPhoto);
                unlink($cheminQrCode);   
            }
            $entityManager->remove($cartePro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
    }
}
