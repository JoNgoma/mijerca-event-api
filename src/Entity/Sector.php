<?php

namespace App\Entity;

use App\Repository\SectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SectorRepository::class)]
#[ApiResource(
    // operations: [
    //     new Get(),
    //     new GetCollection(),
    //     new Post(),
    //     new Put()
    // ],
    normalizationContext: ['groups' => ['sector:read']],
    denormalizationContext: ['groups' => ['sector:write']]
)]
class Sector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sector:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['sector:read', 'sector:write'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'sector', targetEntity: Doyenne::class)]
    #[Groups(['sector:read'])]
    private Collection $doyennes;

    #[ORM\OneToMany(mappedBy: 'sector', targetEntity: Paroisse::class)]
    #[Groups(['sector:read'])]
    private Collection $paroisses;

    #[ORM\OneToMany(mappedBy: 'sector', targetEntity: Person::class)]
    #[Groups(['sector:read'])]
    private Collection $person;

    public function __construct()
    {
        $this->doyennes = new ArrayCollection();
        $this->paroisses = new ArrayCollection();
        $this->person = new ArrayCollection();
    }

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

    public function getDoyenne(): Collection
    {
        return $this->doyennes;
    }

    public function addDoyenne(Doyenne $doyenne): static
    {
        if (!$this->doyennes->contains($doyenne)) {
            $this->doyennes->add($doyenne);
            $doyenne->setSector($this);
        }
        return $this;
    }

    public function removeDoyenne(Doyenne $doyenne): static
    {
        if ($this->doyennes->removeElement($doyenne) && $doyenne->getSector() === $this) {
            $doyenne->setSector(null);
        }
        return $this;
    }

    public function getParoisse(): Collection
    {
        return $this->paroisses;
    }

    public function addParoisse(Paroisse $paroisse): static
    {
        if (!$this->paroisses->contains($paroisse)) {
            $this->paroisses->add($paroisse);
            $paroisse->setSector($this);
        }
        return $this;
    }

    public function removeParoisse(Paroisse $paroisse): static
    {
        if ($this->paroisses->removeElement($paroisse) && $paroisse->getSector() === $this) {
            $paroisse->setSector(null);
        }
        return $this;
    }

    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(Person $person): static
    {
        if (!$this->person->contains($person)) {
            $this->person->add($person);
            $person->setSector($this);
        }
        return $this;
    }

    public function removePerson(Person $person): static
    {
        if ($this->person->removeElement($person) && $person->getSector() === $this) {
            $person->setSector(null);
        }
        return $this;
    }
}
