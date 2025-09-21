<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    // operations: [
    //     new Get(),
    //     new GetCollection(),
    //     new Post(),
    //     new Put()
    // ],
    normalizationContext: ['groups' => ['person:read']],
    denormalizationContext: ['groups' => ['person:write']]
)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['person:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Groups(['person:read', 'person:write'])]
    private ?string $gender = null;

    #[ORM\Column(length: 20)]
    #[Groups(['person:read', 'person:write'])]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['person:read', 'person:write'])]
    private ?string $fullName = null;

    #[ORM\Column]
    #[Groups(['person:read', 'person:write'])]
    private ?bool $isNoyau = null;

    #[ORM\Column]
    #[Groups(['person:read', 'person:write'])]
    private ?bool $isDecanal = null;

    #[ORM\Column]
    #[Groups(['person:read', 'person:write'])]
    private ?bool $isDicoces = null;

    #[ORM\Column]
    #[Groups(['person:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['person:read', 'person:write'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'person')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['person:read', 'person:write'])]
    private ?Doyenne $doyenne = null;

    #[ORM\ManyToOne(inversedBy: 'person')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['person:read', 'person:write'])]
    private ?Paroisse $paroisse = null;

    #[ORM\ManyToOne(inversedBy: 'person')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['person:read', 'person:write'])]
    private ?Sector $sector = null;
    #[ORM\OneToOne(mappedBy: 'person', targetEntity: User::class)]
    private ?User $user = null;

    // --- Getters & Setters ---


    public function getId(): ?int { return $this->id; }
    public function getGender(): ?string { return $this->gender; }
    public function setGender(string $gender): static { $this->gender = $gender; return $this; }
    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function setPhoneNumber(string $phoneNumber): static { $this->phoneNumber = $phoneNumber; return $this; }
    public function getFullName(): ?string { return $this->fullName; }
    public function setFullName(string $fullName): static { $this->fullName = $fullName; return $this; }
    public function IsNoyau(): ?bool { return $this->isNoyau; }
    public function getIsNoyau(): ?bool { return $this->isNoyau; }
    public function setIsNoyau(bool $isNoyau): static { $this->isNoyau = $isNoyau; return $this; }
    public function IsDecanal(): ?bool { return $this->isDecanal; }
    public function getIsDecanal(): ?bool { return $this->isDecanal; }
    public function setIsDecanal(bool $isDecanal): static { $this->isDecanal = $isDecanal; return $this; }
    public function IsDicoces(): ?bool { return $this->isDicoces; }
    public function getIsDicoces(): ?bool { return $this->isDicoces; }
    public function setIsDicoces(bool $isDicoces): static { $this->isDicoces = $isDicoces; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): static { $this->createdAt = $createdAt; return $this; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static { $this->updatedAt = $updatedAt; return $this; }
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    { $this->createdAt = new \DateTimeImmutable(); $this->updatedAt = new \DateTimeImmutable(); }
    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    { $this->updatedAt = new \DateTimeImmutable(); }
    public function getDoyenne(): ?Doyenne { return $this->doyenne; }
    public function setDoyenne(?Doyenne $doyenne): static { $this->doyenne = $doyenne; return $this; }
    public function getParoisse(): ?Paroisse { return $this->paroisse; }
    public function setParoisse(?Paroisse $paroisse): static { $this->paroisse = $paroisse; return $this; }
    public function getSector(): ?Sector { return $this->sector; }
    public function setSector(?Sector $sector): static { $this->sector = $sector; return $this; }
    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }
}
