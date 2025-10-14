<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['user:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $username = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private array $roles = [];

    #[ORM\Column]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Person::class)]
    #[Groups(['user:read', 'user:write'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    /**
     * @var Collection<int, Finance>
     */
    #[Groups(['user:read', 'user:write'])]
    #[ORM\ManyToMany(targetEntity: Finance::class, mappedBy: 'user')]
    private Collection $finances;

    /**
     * @var Collection<int, Administration>
     */
    #[Groups(['user:read', 'user:write'])]
    #[ORM\ManyToMany(targetEntity: Administration::class, mappedBy: 'user')]
    private Collection $administrations;

    /**
     * @var Collection<int, Hebergement>
     */
    #[Groups(['user:read', 'user:write'])]
    #[ORM\ManyToMany(targetEntity: Hebergement::class, mappedBy: 'user')]
    private Collection $hebergements;

    /**
     * @var Collection<int, Informatique>
     */
    #[Groups(['user:read', 'user:write'])]
    #[ORM\ManyToMany(targetEntity: Informatique::class, mappedBy: 'user')]
    private Collection $informatiques;

    public function __construct()
    {
        $this->id = Uuid::v4(); // génère un UUID aléatoire
        $this->finances = new ArrayCollection();
        $this->administrations = new ArrayCollection();
        $this->hebergements = new ArrayCollection();
        $this->informatiques = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    // 🔹 Nouvelle méthode obligatoire pour Symfony >= 5.3
    public function getUserIdentifier(): string
    {
        return $this->username ?? '';
    }

    // 🔹 Ancienne méthode (optionnelle, utile pour compatibilité)
    public function getUsername(): string
    {
        return $this->username ?? '';
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getRoles(): array
    {
        return array_unique(array_merge($this->roles, ['ROLE_USER']));
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password ?? '';
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    // 🔹 Doit retourner void
    public function eraseCredentials(): void
    {
        // Exemple : si tu stockes un mot de passe en clair temporairement
        // $this->plainPassword = null;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): static
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return Collection<int, Finance>
     */
    public function getFinances(): Collection
    {
        return $this->finances;
    }

    public function addFinance(Finance $finance): static
    {
        if (!$this->finances->contains($finance)) {
            $this->finances->add($finance);
            $finance->addUser($this);
        }

        return $this;
    }

    public function removeFinance(Finance $finance): static
    {
        if ($this->finances->removeElement($finance)) {
            $finance->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Administration>
     */
    public function getAdministrations(): Collection
    {
        return $this->administrations;
    }

    public function addAdministration(Administration $administration): static
    {
        if (!$this->administrations->contains($administration)) {
            $this->administrations->add($administration);
            $administration->addUser($this);
        }

        return $this;
    }

    public function removeAdministration(Administration $administration): static
    {
        if ($this->administrations->removeElement($administration)) {
            $administration->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Hebergement>
     */
    public function getHebergements(): Collection
    {
        return $this->hebergements;
    }

    public function addHebergement(Hebergement $hebergement): static
    {
        if (!$this->hebergements->contains($hebergement)) {
            $this->hebergements->add($hebergement);
            $hebergement->addUser($this);
        }

        return $this;
    }

    public function removeHebergement(Hebergement $hebergement): static
    {
        if ($this->hebergements->removeElement($hebergement)) {
            $hebergement->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Informatique>
     */
    public function getInformatiques(): Collection
    {
        return $this->informatiques;
    }

    public function addInformatique(Informatique $informatique): static
    {
        if (!$this->informatiques->contains($informatique)) {
            $this->informatiques->add($informatique);
            $informatique->addUser($this);
        }

        return $this;
    }

    public function removeInformatique(Informatique $informatique): static
    {
        if ($this->informatiques->removeElement($informatique)) {
            $informatique->removeUser($this);
        }

        return $this;
    }
}
