<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[UniqueEntity('libellet')]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libellet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellet(): ?string
    {
        return $this->libellet;
    }

    public function setLibellet(string $libellet): static
    {
        $this->libellet = $libellet;

        return $this;
    }
}
