<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CampBibliqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CampBibliqueRepository::class)]
#[ApiResource]
class CampBiblique
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $start = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $end = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $topic = null;

    #[ORM\OneToOne(mappedBy: 'campBiblic', cascade: ['persist', 'remove'])]
    private ?Finance $finance = null;

    #[ORM\OneToOne(mappedBy: 'campBiblic', cascade: ['persist', 'remove'])]
    private ?Administration $administration = null;

    #[ORM\OneToOne(mappedBy: 'campBiblic', cascade: ['persist', 'remove'])]
    private ?Hebergement $hebergement = null;

    #[ORM\OneToOne(mappedBy: 'campBiblic', cascade: ['persist', 'remove'])]
    private ?Informatique $informatique = null;

    /**
     * @var Collection<int, Participator>
     */
    #[ORM\ManyToMany(targetEntity: Participator::class, mappedBy: 'campBiblic')]
    private Collection $participators;

    /**
     * @var Collection<int, Removal>
     */
    #[ORM\ManyToMany(targetEntity: Removal::class, mappedBy: 'campBiblic')]
    private Collection $removals;

    #[ORM\OneToOne(mappedBy: 'campBiblic', cascade: ['persist', 'remove'])]
    private ?Logistic $logistic = null;

    /**
     * @var Collection<int, Montant>
     */
    #[ORM\ManyToMany(targetEntity: Montant::class, mappedBy: 'campBiblic')]
    private Collection $montants;

    /**
     * @var Collection<int, Cost>
     */
    #[ORM\OneToMany(targetEntity: Cost::class, mappedBy: 'campBiblic')]
    private Collection $costs;

    public function __construct()
    {
        $this->id = Uuid::v4(); // génère un UUID aléatoire
        $this->participators = new ArrayCollection();
        $this->removals = new ArrayCollection();
        $this->montants = new ArrayCollection();
        $this->costs = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    public function setEnd(\DateTimeImmutable $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): static
    {
        $this->topic = $topic;

        return $this;
    }

    public function getFinance(): ?Finance
    {
        return $this->finance;
    }

    public function setFinance(Finance $finance): static
    {
        // set the owning side of the relation if necessary
        if ($finance->getCampBiblic() !== $this) {
            $finance->setCampBiblic($this);
        }

        $this->finance = $finance;

        return $this;
    }

    public function getAdministration(): ?Administration
    {
        return $this->administration;
    }

    public function setAdministration(Administration $administration): static
    {
        // set the owning side of the relation if necessary
        if ($administration->getCampBiblic() !== $this) {
            $administration->setCampBiblic($this);
        }

        $this->administration = $administration;

        return $this;
    }

    public function getHebergement(): ?Hebergement
    {
        return $this->hebergement;
    }

    public function setHebergement(Hebergement $hebergement): static
    {
        // set the owning side of the relation if necessary
        if ($hebergement->getCampBiblic() !== $this) {
            $hebergement->setCampBiblic($this);
        }

        $this->hebergement = $hebergement;

        return $this;
    }

    public function getInformatique(): ?Informatique
    {
        return $this->informatique;
    }

    public function setInformatique(Informatique $informatique): static
    {
        // set the owning side of the relation if necessary
        if ($informatique->getCampBiblic() !== $this) {
            $informatique->setCampBiblic($this);
        }

        $this->informatique = $informatique;

        return $this;
    }

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
            $participator->addCampBiblic($this);
        }

        return $this;
    }

    public function removeParticipator(Participator $participator): static
    {
        if ($this->participators->removeElement($participator)) {
            $participator->removeCampBiblic($this);
        }

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
            $removal->addCampBiblic($this);
        }

        return $this;
    }

    public function removeRemoval(Removal $removal): static
    {
        if ($this->removals->removeElement($removal)) {
            $removal->removeCampBiblic($this);
        }

        return $this;
    }

    public function getLogistic(): ?Logistic
    {
        return $this->logistic;
    }

    public function setLogistic(Logistic $logistic): static
    {
        // set the owning side of the relation if necessary
        if ($logistic->getCb() !== $this) {
            $logistic->setCb($this);
        }

        $this->logistic = $logistic;

        return $this;
    }

    /**
     * @return Collection<int, Montant>
     */
    public function getMontants(): Collection
    {
        return $this->montants;
    }

    public function addMontant(Montant $montant): static
    {
        if (!$this->montants->contains($montant)) {
            $this->montants->add($montant);
            $montant->addCampBiblic($this);
        }

        return $this;
    }

    public function removeMontant(Montant $montant): static
    {
        if ($this->montants->removeElement($montant)) {
            $montant->removeCampBiblic($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Cost>
     */
    public function getCosts(): Collection
    {
        return $this->costs;
    }

    public function addCost(Cost $cost): static
    {
        if (!$this->costs->contains($cost)) {
            $this->costs->add($cost);
            $cost->setCampBiblic($this);
        }

        return $this;
    }

    public function removeCost(Cost $cost): static
    {
        if ($this->costs->removeElement($cost)) {
            // set the owning side to null (unless already changed)
            if ($cost->getCampBiblic() === $this) {
                $cost->setCampBiblic(null);
            }
        }

        return $this;
    }
}
