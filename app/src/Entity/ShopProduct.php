<?php

namespace App\Entity;

use App\Repository\ShopProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopProductRepository::class)]
class ShopProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $producerMainName = null;

    #[ORM\Column(length: 255)]
    private ?string $producerFirstName = null;

    #[ORM\Column]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getProducerMainName(): ?string
    {
        return $this->producerMainName;
    }

    public function setProducerMainName(string $producerMainName): static
    {
        $this->producerMainName = $producerMainName;

        return $this;
    }

    public function getProducerFirstName(): ?string
    {
        return $this->producerFirstName;
    }

    public function setProducerFirstName(string $producerFirstName): static
    {
        $this->producerFirstName = $producerFirstName;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
}
