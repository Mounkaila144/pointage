<?php

namespace App\Controller;

use App\Entity\Autorisation;
use App\Form\AutorisationType;
use App\Repository\AutorisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/autorisation')]
class AutorisationController extends AbstractController
{
    #[Route('/', name: 'app_autorisation_index', methods: ['GET'])]
    public function index(AutorisationRepository $autorisationRepository): Response
    {

        return $this->render('autorisation/index.html.twig', [
            'autorisations' => $autorisationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_autorisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AutorisationRepository $autorisationRepository): Response
    {
        $autorisation = new Autorisation();
        $form = $this->createForm(AutorisationType::class, $autorisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $autorisationRepository->add($autorisation, true);

            return $this->redirectToRoute('app_autorisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('autorisation/new.html.twig', [
            'autorisation' => $autorisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_autorisation_show', methods: ['GET'])]
    public function show(Autorisation $autorisation): Response
    {
        return $this->render('autorisation/show.html.twig', [
            'autorisation' => $autorisation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_autorisation_edit', methods: ['GET', 'POST'])]
    public function edit(int $id,Request $request, Autorisation $autorisation, AutorisationRepository $autorisationRepository): Response
    {
        $p=$autorisationRepository->find($id);

        $form = $this->createForm(AutorisationType::class, $autorisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $autorisation
                ->setDate($p->getDate())
                ->setEmploiyee($p->getEmploiyee());
            $autorisationRepository->add($autorisation, true);

            return $this->redirectToRoute('app_autorisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('autorisation/_form.html.twig', [
            'autorisation' => $autorisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_autorisation_delete', methods: ['POST'])]
    public function delete(Request $request, Autorisation $autorisation, AutorisationRepository $autorisationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autorisation->getId(), $request->request->get('_token'))) {
            $autorisationRepository->remove($autorisation, true);
        }

        return $this->redirectToRoute('app_autorisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
