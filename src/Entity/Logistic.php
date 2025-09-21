<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LogisticRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogisticRepository::class)]
#[ApiResource]
class Logistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'logistic', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CampBiblique $cb = null;

    #[ORM\Column]
    private ?int $dortoirFrere = null;

    #[ORM\Column]
    private ?int $dortoirSoeur = null;

    #[ORM\Column]
    private ?int $carrefour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCb(): ?CampBiblique
    {
        return $this->cb;
    }

    public function setCb(CampBiblique $cb): static
    {
        $this->cb = $cb;

        return $this;
    }

    public function getDortoirFrere(): ?int
    {
        return $this->dortoirFrere;
    }

    public function setDortoirFrere(int $dortoirFrere): static
    {
        $this->dortoirFrere = $dortoirFrere;

        return $this;
    }

    public function getDortoirSoeur(): ?int
    {
        return $this->dortoirSoeur;
    }

    public function setDortoirSoeur(int $dortoirSoeur): static
    {
        $this->dortoirSoeur = $dortoirSoeur;

        return $this;
    }

    public function getCarrefour(): ?int
    {
        return $this->carrefour;
    }

    public function setCarrefour(int $carrefour): static
    {
        $this->carrefour = $carrefour;

        return $this;
    }
}
