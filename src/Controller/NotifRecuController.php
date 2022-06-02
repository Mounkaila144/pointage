<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\Notification1Type;
use App\Repository\NotificatonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('employee/notif/recu')]
class NotifRecuController extends AbstractController
{
    #[Route('/', name: 'app_notif_recu_index', methods: ['GET'])]
    public function index(NotificatonRepository $notificatonRepository): Response
    {
        $id=$this->getUser()->getId();
        return $this->render('notif_recu/index.html.twig', [
            'notifications' => $notificatonRepository->findByemployee($id),
        ]);
    }

    #[Route('/new', name: 'app_notif_recu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NotificatonRepository $notificatonRepository): Response
    {
        $notification = new Notification();
        $form = $this->createForm(Notification1Type::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->setType(1);
            $notificatonRepository->add($notification, true);

            return $this->redirectToRoute('app_notif_recu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notif_recu/new.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_notif_recu_show', methods: ['GET'])]
    public function show(Notification $notification): Response
    {
        return $this->render('notif_recu/show.html.twig', [
            'notification' => $notification,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_notif_recu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Notification $notification, NotificatonRepository $notificatonRepository): Response
    {
        $form = $this->createForm(Notification1Type::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificatonRepository->add($notification, true);

            return $this->redirectToRoute('app_notif_recu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notif_recu/edit.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_notif_recu_delete', methods: ['POST'])]
    public function delete(Request $request, Notification $notification, NotificatonRepository $notificatonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $notificatonRepository->remove($notification, true);
        }

        return $this->redirectToRoute('app_notif_recu_index', [], Response::HTTP_SEE_OTHER);
    }
}
