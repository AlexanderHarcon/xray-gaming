<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $species = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?bool $hasFur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(string $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function hasFur(): ?bool
    {
        return $this->hasFur;
    }

    public function setHasFur(bool $hasFur): static
    {
        $this->hasFur = $hasFur;

        return $this;
    }
}
