<?php

namespace App\Entity;

use App\Repository\QuantityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuantityRepository::class)]
class Quantity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La quantité est obligatoire')]
    #[Assert\Positive(message: 'La quantité doit être positive')]
    #[Assert\Type(type: 'float', message: 'La quantité doit être un nombre')]
    private ?float $quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    #[ORM\ManyToOne(inversedBy: 'quantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip = null;

    #[ORM\ManyToOne(inversedBy: 'quantities', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'L\'ingrédient est obligatoire')]
    private ?Ingredient $ingredient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getTip(): ?Tip
    {
        return $this->tip;
    }

    public function setTip(?Tip $tip): static
    {
        $this->tip = $tip;

        return $this;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }
}
