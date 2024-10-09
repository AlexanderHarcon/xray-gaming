<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\OrderStatus;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAt = null;

    #[ORM\Column(type: "string", enumType: OrderStatus::class)]
    private OrderStatus $status;

    #[ORM\Column]
    private ?float $coinPrice = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $productID = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeInterface $dateAt): static
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCoinPrice(): ?float
    {
        return $this->coinPrice;
    }

    public function setCoinPrice(float $coinPrice): static
    {
        $this->coinPrice = $coinPrice;

        return $this;
    }

    public function getProductID(): array
    {
        return $this->productID;
    }

    public function setProductID(array $productID): static
    {
        $this->productID = $productID;

        return $this;
    }
}
