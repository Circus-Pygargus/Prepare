<?php

namespace App\Entity;

use App\Repository\MeasurementTypeRepository;
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

    public function __construct(

    )
    {
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
}
