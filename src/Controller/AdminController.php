<?php

namespace App\Controller;

use App\Repository\AutorisationRepository;
use App\Repository\EmployeeRepository;
use App\Repository\GroupEmployerRepository;
use App\Repository\NotificatonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(NotificatonRepository $notificatonRepository,AutorisationRepository $autorisationRepository,EmployeeRepository $employeeRepository,GroupEmployerRepository $groupEmployerRepository): Response
    {
        $a=$autorisationRepository->findAll();
        $auth=[];
        foreach ($a as $as){
            $auth[]=$as->getId();
        }
        $e=$employeeRepository->findAll();
        $emplo=[];
        foreach ($e as $es){
            $emplo[]=$es->getId();
        }
        $g=$groupEmployerRepository->findAll();
        $group=[];
        foreach ($g as $gs){
            $group[]=$gs->getId();
        }
        $n = $groupEmployerRepository->findAll();
        $notif = [];
        foreach ($g as $gs) {
            $notif[] =$gs->getId();
        }


        return $this->render('admin/dashboard.html.twig', [
            'auth' => count($auth),
            'emplo' =>count($emplo) ,
            'group' =>count($group) ,
            'notif' =>count($notif) ,
        ]);
    }
    #[Route('/employee', name: 'app_employee')]
    public function employee(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

}
