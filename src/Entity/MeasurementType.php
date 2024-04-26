<?php

namespace App\Entity;

use App\Repository\MeasurementTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementTypeRepository::class)]
class MeasurementType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'measurementTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?IdeaType $ideaType = null;

    #[ORM\OneToMany(targetEntity: Idea::class, mappedBy: 'measurementType')]
    private Collection $ideas;

    #[ORM\OneToMany(targetEntity: MeasurementUnit::class, mappedBy: 'measurementType')]
    private Collection $measurementUnits;

    public function __construct()
    {
        $this->ideas = new ArrayCollection();
        $this->measurementUnits = new ArrayCollection();
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

    public function getIdeaType(): ?IdeaType
    {
        return $this->ideaType;
    }

    public function setIdeaType(?IdeaType $ideaType): static
    {
        $this->ideaType = $ideaType;

        return $this;
    }

    /**
     * @return Collection<int, Idea>
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    public function addIdea(Idea $idea): static
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas->add($idea);
            $idea->setMeasurementType($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): static
    {
        if ($this->ideas->removeElement($idea)) {
            // set the owning side to null (unless already changed)
            if ($idea->getMeasurementType() === $this) {
                $idea->setMeasurementType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MeasurementUnit>
     */
    public function getMeasurementUnits(): Collection
    {
        return $this->measurementUnits;
    }

    public function addMeasurementUnit(MeasurementUnit $measurementUnit): static
    {
        if (!$this->measurementUnits->contains($measurementUnit)) {
            $this->measurementUnits->add($measurementUnit);
            $measurementUnit->setMeasurementType($this);
        }

        return $this;
    }

    public function removeMeasurementUnit(MeasurementUnit $measurementUnit): static
    {
        if ($this->measurementUnits->removeElement($measurementUnit)) {
            // set the owning side to null (unless already changed)
            if ($measurementUnit->getMeasurementType() === $this) {
                $measurementUnit->setMeasurementType(null);
            }
        }

        return $this;
    }
}
