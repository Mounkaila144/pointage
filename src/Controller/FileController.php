<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('image/face/{img}', name: 'image')]
    public function index($img): Response
    {
        //Récupération du dossier racine grace au kernel et ensuite ajout de l'emplacement du
        //fichier
        $filename = $this->getParameter('kernel.project_dir') . '/public/file/images/' . $img;
        //Si le fichier existe alors on le renvoi, sinon retour 404
        if (file_exists($filename)) {
            //retour d'un new BinaryFileResponse avec le nom du fichier
            return new BinaryFileResponse($filename);
        } else {
            return new JsonResponse(null, 404);
        }
    }

}
