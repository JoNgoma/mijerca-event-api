<?php

namespace App\Entity;

use App\Repository\ParoisseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParoisseRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    // operations: [
    //     new Get(),
    //     new GetCollection(),
    //     new Post(),
    //     new Put()
    // ],
    normalizationContext: ['groups' => ['paroisse:read']],
    denormalizationContext: ['groups' => ['paroisse:write']]
)]
class Paroisse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['paroisse:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['paroisse:read', 'paroisse:write'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'paroisses')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['paroisse:read', 'paroisse:write'])]
    private ?Doyenne $doyenne = null;

    #[ORM\Column]
    #[Groups(['paroisse:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['paroisse:read', 'paroisse:write'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'paroisse', targetEntity: Person::class, cascade: ['persist', 'remove'])]
    #[Groups(['paroisse:read'])]
    private Collection $person;

    #[ORM\ManyToOne(inversedBy: 'paroisses')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['paroisse:read', 'paroisse:write'])]
    private ?Sector $sector = null;

    public function __construct() { $this->person = new ArrayCollection(); }

    // --- Getters & Setters ---

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }
    public function getDoyenne(): ?Doyenne { return $this->doyenne; }
    public function setDoyenne(?Doyenne $doyenne): static { $this->doyenne = $doyenne; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void { $this->createdAt = new \DateTimeImmutable(); $this->updatedAt = new \DateTimeImmutable(); }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void { $this->updatedAt = new \DateTimeImmutable(); }

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
            $person->setParoisse($this);
        }
        return $this;
    }

    public function removePerson(Person $person): static
    {
        if ($this->person->removeElement($person)) {
            if ($person->getParoisse() === $this) {
                $person->setParoisse(null);
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
