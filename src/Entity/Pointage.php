<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PointageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['emploiyee' => 'exact'])]
#[ORM\Entity(repositoryClass: PointageRepository::class)]
class Pointage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $type;
    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'pointages')]
    #[ORM\JoinColumn(nullable: false)]
    private $emploiyee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getEmploiyee(): ?Employee
    {
        return $this->emploiyee;
    }

    public function setEmploiyee(?Employee $emploiyee): self
    {
        $this->emploiyee = $emploiyee;

        return $this;
    }
}
