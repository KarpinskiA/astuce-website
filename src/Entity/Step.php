<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\StepRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'L\'ordre de l\'étape est obligatoire')]
    #[Assert\Positive(message: 'L\'ordre de l\'étape doit être un nombre supérieur à 1')]
    private ?int $orderNumber = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La description de l\'étape est obligatoire')]
    #[Assert\Length(
        min: 10,
        minMessage: 'La description de l\'étape doit contenir au moins {{ limit }} caractères'
    )]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
}
