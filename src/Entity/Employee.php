<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`employee`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\Index(name: '`employee`', columns: ['nom', 'prenom','email'], flags: ['fulltext'])]
class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(type: 'string', length: 50)]
    private $nom;

    #[ORM\Column(type: 'string', length: 50)]
    private $prenom;

    #[ORM\OneToMany(mappedBy: 'emploiyee', targetEntity: Autorisation::class)]
    private $autorisations;

    #[ORM\Column(type: 'date', nullable: true)]
    private $naissance;

    #[ORM\ManyToMany(targetEntity: Notification::class, mappedBy: 'employee')]
    private $notificatons;

    #[ORM\ManyToOne(targetEntity: GroupEmployer::class, inversedBy: 'employees')]
    private $groupe;

    #[ORM\OneToMany(mappedBy: 'emploiyee', targetEntity: Pointage::class)]
    private $pointages;


    public function __toString(): string
    {
        return $this->getNom();
    }


    public function __construct()
    {
        $this->autorisations = new ArrayCollection();
        $this->notificatons = new ArrayCollection();
        $this->pointages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }


    /**
     * @return Collection<int, Autorisation>
     */
    public function getAutorisations(): Collection
    {
        return $this->autorisations;
    }

    public function addAutorisation(Autorisation $autorisation): self
    {
        if (!$this->autorisations->contains($autorisation)) {
            $this->autorisations[] = $autorisation;
            $autorisation->setEmploiyee($this);
        }

        return $this;
    }

    public function removeAutorisation(Autorisation $autorisation): self
    {
        if ($this->autorisations->removeElement($autorisation)) {
            // set the owning side to null (unless already changed)
            if ($autorisation->getEmploiyee() === $this) {
                $autorisation->setEmploiyee(null);
            }
        }

        return $this;
    }

    public function getNaissance(): ?\DateTimeInterface
    {
        return $this->naissance;
    }

    public function setNaissance(?\DateTimeInterface $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotificatons(): Collection
    {
        return $this->notificatons;
    }

    public function addNotificaton(Notification $notificaton): self
    {
        if (!$this->notificatons->contains($notificaton)) {
            $this->notificatons[] = $notificaton;
            $notificaton->addEmployee($this);
        }

        return $this;
    }

    public function removeNotificaton(Notification $notificaton): self
    {
        if ($this->notificatons->removeElement($notificaton)) {
            $notificaton->removeEmployee($this);
        }

        return $this;
    }

    public function getGroupe(): ?GroupEmployer
    {
        return $this->groupe;
    }

    public function setGroupe(?GroupEmployer $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection<int, Pointage>
     */
    public function getPointages(): Collection
    {
        return $this->pointages;
    }

    public function addPointage(Pointage $pointage): self
    {
        if (!$this->pointages->contains($pointage)) {
            $this->pointages[] = $pointage;
            $pointage->setEmploiyee($this);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointages->removeElement($pointage)) {
            // set the owning side to null (unless already changed)
            if ($pointage->getEmploiyee() === $this) {
                $pointage->setEmploiyee(null);
            }
        }

        return $this;
    }

}
