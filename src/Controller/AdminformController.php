<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\Admin2Type;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/adminform')]
class AdminformController extends AbstractController
{
    #[Route('/', name: 'app_adminform_index', methods: ['GET'])]
    public function index(AdminRepository $adminRepository): Response
    {
        return $this->render('adminform/index.html.twig', [
            'admins' => $adminRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_adminform_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AdminRepository $adminRepository): Response
    {
        $admin = new Admin();
        $form = $this->createForm(Admin2Type::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminRepository->add($admin, true);

            return $this->redirectToRoute('app_adminform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminform/new.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adminform_show', methods: ['GET'])]
    public function show(Admin $admin): Response
    {
        return $this->render('adminform/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_adminform_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Admin $admin, AdminRepository $adminRepository): Response
    {
        $form = $this->createForm(Admin2Type::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminRepository->add($admin, true);

            return $this->redirectToRoute('app_adminform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminform/edit.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adminform_delete', methods: ['POST'])]
    public function delete(Request $request, Admin $admin, AdminRepository $adminRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $adminRepository->remove($admin, true);
        }

        return $this->redirectToRoute('app_adminform_index', [], Response::HTTP_SEE_OTHER);
    }
}
