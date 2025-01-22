<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom du matériel est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le nom du matériel doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le nom du matériel ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip = null;

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
