<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MontantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MontantRepository::class)]
#[ApiResource]
class Montant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, CampBiblique>
     */
    #[ORM\ManyToMany(targetEntity: CampBiblique::class, inversedBy: 'montants')]
    private Collection $campBiblic;

    #[ORM\OneToOne(inversedBy: 'montant', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participator $participator = null;

    #[ORM\Column(length: 15)]
    private ?string $devise = null;

    #[ORM\Column]
    private ?int $frais = null;

    #[ORM\Column(length: 10)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->campBiblic = new ArrayCollection();
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

    public function getParticipator(): ?Participator
    {
        return $this->participator;
    }

    public function setParticipator(Participator $participator): static
    {
        $this->participator = $participator;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): static
    {
        $this->frais = $frais;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
