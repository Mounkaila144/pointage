<?php

namespace App\Service;

use App\Entity\Autorisation;
use App\Entity\Notification;
use App\Repository\AutorisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\TwigFunction;

class nb extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function a()
    {
        $a = $this->em->getRepository(Autorisation::class)->findAll();
        $auth = [];
        foreach ($a as $as) {
            $auth[] = $as->getId();
        }
        return count($auth);
    }

    public function b()
    {
        $id=$this->getUser()->getId();
        $a = $this->em->getRepository(Notification::class)->createQueryBuilder('n')
            ->join('n.employee','e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $id)
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
        $auth = [];
        foreach ($a as $as) {
            $auth[] = $as->getId();
        }
        return count($auth);
    }


}