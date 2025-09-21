<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ParticipatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipatorRepository::class)]
#[ApiResource]
class Participator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, CampBiblique>
     */
    #[ORM\ManyToMany(targetEntity: CampBiblique::class, inversedBy: 'participators')]
    private Collection $campBiblic;

    #[ORM\ManyToOne(inversedBy: 'participators')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    #[ORM\Column(length: 255)]
    private ?string $carrefour = null;

    #[ORM\Column(length: 255)]
    private ?string $dortoir = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Removal>
     */
    #[ORM\ManyToMany(targetEntity: Removal::class, mappedBy: 'participator')]
    private Collection $removals;

    #[ORM\OneToOne(mappedBy: 'participator', cascade: ['persist', 'remove'])]
    private ?Montant $montant = null;

    public function __construct()
    {
        $this->campBiblic = new ArrayCollection();
        $this->removals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CampBiblique>
     */
    public function getCampBiblic(): Collection
    {
        return $this->campBiblic;
    }

    public function addCampBiblic(CampBiblique $campBiblic): static
    {
        if (!$this->campBiblic->contains($campBiblic)) {
            $this->campBiblic->add($campBiblic);
        }

        return $this;
    }

    public function removeCampBiblic(CampBiblique $campBiblic): static
    {
        $this->campBiblic->removeElement($campBiblic);

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): static
    {
        $this->person = $person;

        return $this;
    }

    public function getCarrefour(): ?string
    {
        return $this->carrefour;
    }

    public function setCarrefour(string $carrefour): static
    {
        $this->carrefour = $carrefour;

        return $this;
    }

    public function getDortoir(): ?string
    {
        return $this->dortoir;
    }

    public function setDortoir(string $dortoir): static
    {
        $this->dortoir = $dortoir;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Removal>
     */
    public function getRemovals(): Collection
    {
        return $this->removals;
    }

    public function addRemoval(Removal $removal): static
    {
        if (!$this->removals->contains($removal)) {
            $this->removals->add($removal);
            $removal->addParticipator($this);
        }

        return $this;
    }

    public function removeRemoval(Removal $removal): static
    {
        if ($this->removals->removeElement($removal)) {
            $removal->removeParticipator($this);
        }

        return $this;
    }

    public function getMontant(): ?Montant
    {
        return $this->montant;
    }

    public function setMontant(Montant $montant): static
    {
        // set the owning side of the relation if necessary
        if ($montant->getParticipator() !== $this) {
            $montant->setParticipator($this);
        }

        $this->montant = $montant;

        return $this;
    }
}
