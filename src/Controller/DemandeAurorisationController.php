<?php

namespace App\Controller;

use App\Entity\Autorisation;
use App\Form\Autorisation1Type;
use App\Repository\AutorisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('employee/demande/aurorisation')]
class DemandeAurorisationController extends AbstractController
{
    #[Route('/', name: 'app_demande_aurorisation_index', methods: ['GET'])]
    public function index(AutorisationRepository $autorisationRepository): Response
    {
        $id=$this->getUser()->getId();
        return $this->render('demande_aurorisation/index.html.twig', [
            'autorisations' => $autorisationRepository->findBy(['emploiyee'=>$id]),
        ]);
    }

    #[Route('/new', name: 'app_demande_aurorisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AutorisationRepository $autorisationRepository): Response
    {
        $id=$this->getUser();
        $autorisation = new Autorisation();
        $form = $this->createForm(Autorisation1Type::class, $autorisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $autorisation->setEmploiyee($id);
            $autorisation->setStatus(1);
            $autorisationRepository->add($autorisation, true);

            return $this->redirectToRoute('app_demande_aurorisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_aurorisation/new.html.twig', [
            'autorisation' => $autorisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_aurorisation_show', methods: ['GET'])]
    public function show(Autorisation $autorisation): Response
    {
        return $this->render('demande_aurorisation/show.html.twig', [
            'autorisation' => $autorisation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demande_aurorisation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Autorisation $autorisation, AutorisationRepository $autorisationRepository): Response
    {
        $form = $this->createForm(Autorisation1Type::class, $autorisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $autorisationRepository->add($autorisation, true);

            return $this->redirectToRoute('app_demande_aurorisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_aurorisation/edit.html.twig', [
            'autorisation' => $autorisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_aurorisation_delete', methods: ['POST'])]
    public function delete(Request $request, Autorisation $autorisation, AutorisationRepository $autorisationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autorisation->getId(), $request->request->get('_token'))) {
            $autorisationRepository->remove($autorisation, true);
        }

        return $this->redirectToRoute('app_demande_aurorisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
