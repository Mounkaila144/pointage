<?php

namespace App\Entity;

use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: SocieteRepository::class)]
class Societe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $localisation;


    #[ORM\Column(type: 'string', length: 50)]
    private $dureePause;

    #[ORM\Column(type: 'integer')]
    private $nombreEmloyee;

    #[ORM\Column(type: 'time')]
    private $heureDebutTravail;

    #[ORM\Column(type: 'time')]
    private $heureFinTravail;

    public function __toString(): string
    {
        return $this->getNom();
    }


    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }


    public function getDureePause(): ?string
    {
        return $this->dureePause;
    }

    public function setDureePause(string $dureePause): self
    {
        $this->dureePause = $dureePause;

        return $this;
    }

    public function getNombreEmloyee(): ?int
    {
        return $this->nombreEmloyee;
    }

    public function setNombreEmloyee(int $nombreEmloyee): self
    {
        $this->nombreEmloyee = $nombreEmloyee;

        return $this;
    }

    public function getHeureDebutTravail(): ?\DateTimeInterface
    {
        return $this->heureDebutTravail;
    }

    public function setHeureDebutTravail(\DateTimeInterface $heureDebutTravail): self
    {
        $this->heureDebutTravail = $heureDebutTravail;

        return $this;
    }

    public function getHeureFinTravail(): ?\DateTimeInterface
    {
        return $this->heureFinTravail;
    }

    public function setHeureFinTravail(\DateTimeInterface $heureFinTravail): self
    {
        $this->heureFinTravail = $heureFinTravail;

        return $this;
    }

}
