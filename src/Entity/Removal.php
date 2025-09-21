<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RemovalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemovalRepository::class)]
#[ApiResource]
class Removal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, CampBiblique>
     */
    #[ORM\ManyToMany(targetEntity: CampBiblique::class, inversedBy: 'removals')]
    private Collection $campBiblic;

    /**
     * @var Collection<int, Participator>
     */
    #[ORM\ManyToMany(targetEntity: Participator::class, inversedBy: 'removals')]
    private Collection $participator;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $motif = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $start = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $end = null;

    public function __construct()
    {
        $this->campBiblic = new ArrayCollection();
        $this->participator = new ArrayCollection();
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

    /**
     * @return Collection<int, Participator>
     */
    public function getParticipator(): Collection
    {
        return $this->participator;
    }

    public function addParticipator(Participator $participator): static
    {
        if (!$this->participator->contains($participator)) {
            $this->participator->add($participator);
        }

        return $this;
    }

    public function removeParticipator(Participator $participator): static
    {
        $this->participator->removeElement($participator);

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

    public function getStart(): ?\DateTimeImmutable
    {
        return $this->start;
    }

    public function setStart(\DateTimeImmutable $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeImmutable
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeImmutable $end): static
    {
        $this->end = $end;

        return $this;
    }
}
