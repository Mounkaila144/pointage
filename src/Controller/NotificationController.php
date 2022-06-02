<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\Notification1Type;
use App\Form\NotificationType;
use App\Repository\EmployeeRepository;
use App\Repository\NotificatonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/notification')]
class NotificationController extends AbstractController
{
    #[Route('/', name: 'app_notification_index', methods: ['GET'])]
    public function index(NotificatonRepository $notificatonRepository): Response
    {
        $p=$notificatonRepository->findAll();
        return $this->render('notification/index.html.twig', [
            'notifications' => $notificatonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_notification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NotificatonRepository $notificatonRepository): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificatonRepository->add($notification, true);

            return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notification/new.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }

    #[Route('/notif/employer/{id}', name: 'app_notif_employer_new', methods: ['GET', 'POST'])]
    public function new1(Request $request, NotificatonRepository $notificatonRepository,int $id,EmployeeRepository $employeeRepository): Response
    {
        $employees=$employeeRepository->find($id);
        $notification = new Notification();
        $form = $this->createForm(Notification1Type::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->addEmployee($employees);
            $notificatonRepository->add($notification, true);

            return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notification/new.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_notification_show', methods: ['GET'])]
    public function show(Notification $notification): Response
    {
        return $this->render('notification/show.html.twig', [
            'notification' => $notification,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_notification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Notification $notification, NotificatonRepository $notificatonRepository): Response
    {
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificatonRepository->add($notification, true);

            return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notification/edit.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_notification_delete', methods: ['POST'])]
    public function delete(Request $request, Notification $notification, NotificatonRepository $notificatonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $notificatonRepository->remove($notification, true);
        }

        return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
    }
}
