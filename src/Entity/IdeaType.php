<?php

namespace App\Entity;

use App\Repository\IdeaTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdeaTypeRepository::class)]
class IdeaType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: MeasurementType::class, mappedBy: 'ideaType')]
    private Collection $measurementTypes;

    public function __construct()
    {
        $this->measurementTypes = new ArrayCollection();
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

    /**
     * @return Collection<int, MeasurementType>
     */
    public function getMeasurementTypes(): Collection
    {
        return $this->measurementTypes;
    }

    public function addMeasurementType(MeasurementType $measurementType): static
    {
        if (!$this->measurementTypes->contains($measurementType)) {
            $this->measurementTypes->add($measurementType);
            $measurementType->setIdeaType($this);
        }

        return $this;
    }

    public function removeMeasurementType(MeasurementType $measurementType): static
    {
        if ($this->measurementTypes->removeElement($measurementType)) {
            // set the owning side to null (unless already changed)
            if ($measurementType->getIdeaType() === $this) {
                $measurementType->setIdeaType(null);
            }
        }

        return $this;
    }
}
