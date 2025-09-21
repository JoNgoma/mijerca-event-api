<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CostRepository::class)]
#[ApiResource]
class Cost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'costs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CampBiblique $campBiblic = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $motif = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Montant $montant = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampBiblic(): ?CampBiblique
    {
        return $this->campBiblic;
    }

    public function setCampBiblic(?CampBiblique $campBiblic): static
    {
        $this->campBiblic = $campBiblic;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getMontant(): ?Montant
    {
        return $this->montant;
    }

    public function setMontant(?Montant $montant): static
    {
        $this->montant = $montant;

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
}
