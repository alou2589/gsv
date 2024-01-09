<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/role')]
class RoleController extends AbstractController
{
    #[Route('/', name: 'app_admin_role_index', methods: ['GET'])]
    public function index(RoleRepository $roleRepository): Response
    {
        return $this->render('admin/role/index.html.twig', [
            'roles' => $roleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_role_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($role);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/role/new.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_role_show', methods: ['GET'])]
    public function show(Role $role,UserRepository $userRepository,): Response
    {
        return $this->render('admin/role/show.html.twig', [
            'role' => $role,
            'userRoles'=>$userRepository->findBy(['roles'=>[$role->getNomRole()]])
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_role_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Role $role, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/role/edit.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_role_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Role $role, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
            $entityManager->remove($role);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/role/delete.html.twig',[
            'role'=>$role,
        ]);

    }
    
    #[Route('/{id}/liste', name: 'app_admin_role_liste_users', methods: ['GET', 'POST'])]
    public function listeUser(Role $role, UserRepository $userRepository)
    {
        $userRoles=$userRepository->findBy(['nom_role'=>$role->getNomRole()]);
        return $this->render('admin/role/liste.html.twig',[
            'userRoles'=>$userRoles,
        ]);
    }
}
