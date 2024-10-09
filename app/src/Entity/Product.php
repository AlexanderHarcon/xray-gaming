<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CSCase $cSCase = null;

    /**
     * @var Collection<int, Winning>
     */
    #[ORM\OneToMany(targetEntity: Winning::class, mappedBy: 'productID')]
    private Collection $winnings;

    public function __construct()
    {
        $this->winnings = new ArrayCollection();
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

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

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

    public function getCSCase(): ?CSCase
    {
        return $this->cSCase;
    }

    public function setCSCase(?CSCase $cSCase): static
    {
        $this->cSCase = $cSCase;

        return $this;
    }

    /**
     * @return Collection<int, Winning>
     */
    public function getWinnings(): Collection
    {
        return $this->winnings;
    }

    public function addWinning(Winning $winning): static
    {
        if (!$this->winnings->contains($winning)) {
            $this->winnings->add($winning);
            $winning->setProductID($this);
        }

        return $this;
    }

    public function removeWinning(Winning $winning): static
    {
        if ($this->winnings->removeElement($winning)) {
            // set the owning side to null (unless already changed)
            if ($winning->getProductID() === $this) {
                $winning->setProductID(null);
            }
        }

        return $this;
    }


}
