<?php

namespace App\Entity;

use App\Repository\MeasurementUnitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementUnitRepository::class)]
class MeasurementUnit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $coef = null;

    #[ORM\ManyToOne(inversedBy: 'measurementUnits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MeasurementType $measurementType = null;

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

    public function getCoef(): ?int
    {
        return $this->coef;
    }

    public function setCoef(int $coef): static
    {
        $this->coef = $coef;

        return $this;
    }

    public function getMeasurementType(): ?MeasurementType
    {
        return $this->measurementType;
    }

    public function setMeasurementType(?MeasurementType $measurementType): static
    {
        $this->measurementType = $measurementType;

        return $this;
    }
}
