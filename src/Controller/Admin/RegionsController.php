<?php

namespace App\Controller\Admin;

use App\Entity\Regions;
use App\Form\RegionsType;
use App\Repository\AffectationRepository;
use App\Repository\RegionsRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/regions')]
class RegionsController extends AbstractController
{
    #[Route('/', name: 'app_admin_regions_index', methods: ['GET'])]
    public function index(RegionsRepository $regionsRepository): Response
    {
        return $this->render('admin/regions/index.html.twig', [
            'regions' => $regionsRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_admin_regions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $region = new Regions();
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($region);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_regions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/regions/new.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/show', name: 'app_admin_regions_show', methods: ['GET'])]
    public function show(Regions $region, AffectationRepository $affectationRepository): Response
    {
        $regionVolontaires=$affectationRepository->regionVolontaires($region);
        return $this->render('admin/regions/show.html.twig', [
            'region' => $region,
            'regionVolontaires' => $regionVolontaires,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_regions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Regions $region, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_regions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/regions/edit.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_regions_delete', methods: ['POST'])]
    public function delete(Request $request, Regions $region, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $entityManager->remove($region);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_regions_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/upload-excel', name: 'app_admin_import_xlsx', methods: ['GET','POST'])]
    public function xslx(Request $request, EntityManagerInterface $entityManager) :Response
    {
    
        $file = $request->files->get('nom_region'); // get the file from the sent request
   
        $fileFolder = __DIR__ . '/../../public/assets/uploads/excelImports/';  //choose the folder in which the uploaded file will be stored
  
        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
      // apply md5 function to generate an unique identifier for the file and concat it with the file extension  
            try {
                $file->move($fileFolder, $filePathName);
            } catch (FileException $e) {
                dd($e);
            }
        $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file 
        $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
        //dd($sheetData);
        foreach ($sheetData as $Row) 
            { 
    
                $nom_region = $Row['A'];   // store the phone on each iteration
    
                $region_existant = $entityManager->getRepository(Regions::class)->findOneBy(array('nom_region' => $nom_region)); 
                    // make sure that the user does not already exists in your db 
                if (!$region_existant) 
                 {   
                    $region = new Regions(); 
                    $region->setNomRegion($nom_region);  
                    $entityManager->persist($region); 
                    $entityManager->flush(); 
                     // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                 } 
            }         
            return $this->render('admin/regions/new.html.twig', [
                'region' => $region,
            ]);
    }
    
 
}
