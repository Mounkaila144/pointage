<?php

namespace App\Entity;

use App\Repository\AutorisationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: AutorisationRepository::class)]
#[ApiResource]
class Autorisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'autorisations')]
    #[ORM\JoinColumn(nullable: false)]
    private $emploiyee;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'integer')]
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmploiyee(): ?Employee
    {
        return $this->emploiyee;
    }

    public function setEmploiyee(?Employee $emploiyee): self
    {
        $this->emploiyee = $emploiyee;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
