<?php

namespace App\Controller;

use App\Entity\GroupEmployer;
use App\Form\GroupEmployerType;
use App\Repository\EmployeeRepository;
use App\Repository\GroupEmployerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/group/employer')]
class GroupEmployerController extends AbstractController
{
    #[Route('/', name: 'app_group_employer_index', methods: ['GET'])]
    public function index(GroupEmployerRepository $groupEmployerRepository): Response
    {
        return $this->render('group_employer/index.html.twig', [
            'group_employers' => $groupEmployerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_group_employer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GroupEmployerRepository $groupEmployerRepository): Response
    {
        $groupEmployer = new GroupEmployer();
        $form = $this->createForm(GroupEmployerType::class, $groupEmployer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupEmployerRepository->add($groupEmployer, true);

            return $this->redirectToRoute('app_group_employer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('group_employer/new.html.twig', [
            'group_employer' => $groupEmployer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_group_employer_show', methods: ['GET'])]
    public function show(GroupEmployer $groupEmployer,EmployeeRepository $employeeRepository,int $id): Response
    {
        $employee=$employeeRepository->findBy(['groupe'=>$id]);
        return $this->render('group_employer/show.html.twig', [
            'group_employer' => $groupEmployer,
            'employees' => $employee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_group_employer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GroupEmployer $groupEmployer, GroupEmployerRepository $groupEmployerRepository): Response
    {
        $form = $this->createForm(GroupEmployerType::class, $groupEmployer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupEmployerRepository->add($groupEmployer, true);

            return $this->redirectToRoute('app_group_employer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('group_employer/edit.html.twig', [
            'group_employer' => $groupEmployer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_group_employer_delete', methods: ['POST'])]
    public function delete(Request $request, GroupEmployer $groupEmployer, GroupEmployerRepository $groupEmployerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupEmployer->getId(), $request->request->get('_token'))) {
            $groupEmployerRepository->remove($groupEmployer, true);
        }

        return $this->redirectToRoute('app_group_employer_index', [], Response::HTTP_SEE_OTHER);
    }
}
