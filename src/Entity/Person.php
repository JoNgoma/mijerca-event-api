<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

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
#[UniqueEntity(
    fields: ['phoneNumber'],
    message: 'Ce numéro de téléphone est déjà utilisé.'
)]
class Person
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['person:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 10)]
    #[Groups(['person:read', 'person:write'])]
    private ?string $gender = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Groups(['person:read', 'person:write'])]
    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['person:read', 'person:write'])]
    #[Assert\NotBlank(message: "Le nom complet est obligatoire.")]
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
    #[Assert\NotBlank(message: "La selection du doyenné est obligatoire.")]
    private ?Doyenne $doyenne = null;

    #[ORM\ManyToOne(inversedBy: 'person')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['person:read', 'person:write'])]
    #[Assert\NotBlank(message: "La selection de la paroisse est obligatoire.")]
    private ?Paroisse $paroisse = null;

    #[ORM\ManyToOne(inversedBy: 'person')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['person:read', 'person:write'])]
    private ?Sector $sector = null;
    #[ORM\OneToOne(mappedBy: 'person', targetEntity: User::class)]
    private ?User $user = null;

    /**
     * @var Collection<int, Participator>
     */
    #[ORM\OneToMany(targetEntity: Participator::class, mappedBy: 'person')]
    private Collection $participators;

    public function __construct()
    {
        $this->id = Uuid::v4(); // génère un UUID aléatoire
        $this->participators = new ArrayCollection();
    }

    // --- Getters & Setters ---


    public function getId(): ?Uuid { return $this->id; }
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

    /**
     * @return Collection<int, Participator>
     */
    public function getParticipators(): Collection
    {
        return $this->participators;
    }

    public function addParticipator(Participator $participator): static
    {
        if (!$this->participators->contains($participator)) {
            $this->participators->add($participator);
            $participator->setPerson($this);
        }

        return $this;
    }

    public function removeParticipator(Participator $participator): static
    {
        if ($this->participators->removeElement($participator)) {
            // set the owning side to null (unless already changed)
            if ($participator->getPerson() === $this) {
                $participator->setPerson(null);
            }
        }

        return $this;
    }
}
