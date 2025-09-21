<?php

namespace App\Entity;

use App\Repository\DoyenneRepository;
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

#[ORM\Entity(repositoryClass: DoyenneRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    // operations: [
    //     new Get(),
    //     new GetCollection(),
    //     new Post(),
    //     new Put()
    // ],
    normalizationContext: ['groups' => ['doyenne:read']],
    denormalizationContext: ['groups' => ['doyenne:write']]
)]
#[UniqueEntity(
    fields: ['name'],
    message: 'Ce doyenné existe déjà.'
)]
class Doyenne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['doyenne:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['doyenne:read', 'doyenne:write'])]
    #[Assert\NotBlank(message: "Le nom du doyenné est obligatoire.")]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['doyenne:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['doyenne:read', 'doyenne:write'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'doyenne', targetEntity: Paroisse::class, cascade: ['persist', 'remove'])]
    #[Groups(['doyenne:read'])]
    private Collection $paroisses;

    #[ORM\OneToMany(mappedBy: 'doyenne', targetEntity: Person::class, cascade: ['persist', 'remove'])]
    #[Groups(['doyenne:read'])]
    private Collection $person;

    #[ORM\ManyToOne(inversedBy: 'doyennes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['doyenne:read', 'doyenne:write'])]
    private ?Sector $sector = null;

    public function __construct()
    {
        $this->paroisses = new ArrayCollection();
        $this->person = new ArrayCollection();
    }

    // --- Getters & Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    // --- Paroisses ---

    /**
     * @return Collection<int, Paroisse>
     */
    public function getParoisses(): Collection
    {
        return $this->paroisses;
    }

    public function addParoiss(Paroisse $paroiss): static
    {
        if (!$this->paroisses->contains($paroiss)) {
            $this->paroisses->add($paroiss);
            $paroiss->setDoyenne($this);
        }
        return $this;
    }

    public function removeParoiss(Paroisse $paroiss): static
    {
        if ($this->paroisses->removeElement($paroiss)) {
            if ($paroiss->getDoyenne() === $this) {
                $paroiss->setDoyenne(null);
            }
        }
        return $this;
    }

    // --- Person ---

    /**
     * @return Collection<int, Person>
     */
    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(Person $person): static
    {
        if (!$this->person->contains($person)) {
            $this->person->add($person);
            $person->setDoyenne($this);
        }
        return $this;
    }

    public function removePerson(Person $person): static
    {
        if ($this->person->removeElement($person)) {
            if ($person->getDoyenne() === $this) {
                $person->setDoyenne(null);
            }
        }
        return $this;
    }

    // --- Sector ---

    public function getSector(): ?Sector
    {
        return $this->sector;
    }

    public function setSector(?Sector $sector): static
    {
        $this->sector = $sector;
        return $this;
    }
}
