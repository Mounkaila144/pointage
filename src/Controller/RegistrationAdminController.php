<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegistrationAdminFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationAdminController extends AbstractController
{
    #[Route('/register/admin', name: 'app_register_admin_admin')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $admin = new Admin();
        $form = $this->createForm(RegistrationAdminFormType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $admin->setRoles(["ROLE_ADMIN"]);
            $admin->setPassword(
            $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($admin);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('registration/admin/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
