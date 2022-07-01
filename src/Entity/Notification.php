<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\NotificatonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['employee.id' => 'exact'])]
#[ORM\Entity(repositoryClass: NotificatonRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Employee::class, inversedBy: 'notifications')]
    private $employee;

    #[ORM\ManyToMany(targetEntity: GroupEmployer::class, inversedBy: 'notifications')]
    private $groupemployer;

    #[ORM\Column(type: 'text')]
    private $message;

    #[ORM\Column(type: 'string', length: 50)]
    private $type;

    public function __construct()
    {
        $this->employee = new ArrayCollection();
        $this->groupemployer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployee(): Collection
    {
        return $this->employee;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employee->contains($employee)) {
            $this->employee[] = $employee;
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        $this->employee->removeElement($employee);

        return $this;
    }

    /**
     * @return Collection<int, GroupEmployer>
     */
    public function getGroupemployer(): Collection
    {
        return $this->groupemployer;
    }

    public function addGroupemployer(GroupEmployer $groupemployer): self
    {
        if (!$this->groupemployer->contains($groupemployer)) {
            $this->groupemployer[] = $groupemployer;
        }

        return $this;
    }

    public function removeGroupemployer(GroupEmployer $groupemployer): self
    {
        $this->groupemployer->removeElement($groupemployer);

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
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

}
