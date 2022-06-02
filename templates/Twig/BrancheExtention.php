<?php

namespace App\Twig;
use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;



use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BrancheExtention extends AbstractExtension
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bran',[$this,'getBranches'])
        ];
    }
    public function getBranches()
    {
        return $this->em->getRepository(Etudiant::class)->findAll();
    }

}
                                                               