<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $username = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Person::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    public function getId(): ?int
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

        // Attribution automatique des rôles selon le type de personne
        if ($person->isNoyau()) {
            $this->roles = ['ROLE_NOYAU'];
        } elseif ($person->isDecanal()) {
            $this->roles = ['ROLE_DECANAL'];
        } elseif ($person->isDicoces()) {
            $this->roles = ['ROLE_DIOCESE'];
        }

        return $this;
    }
}
