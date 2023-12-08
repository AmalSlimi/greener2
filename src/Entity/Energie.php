<?php

namespace App\Entity;

use App\Repository\EnergieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
#[ORM\Entity(repositoryClass: EnergieRepository::class)]
#[UniqueEntity('libelletEnergie')]
class Energie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelletEnergie = null;

    #[ORM\Column(nullable: true)]
    private ?float $pollutionParKw = null;

    public function getIdEnergie(): ?int
    {
        return $this->id;
    }

    public function getLibelletEnergie(): ?string
    {
        return $this->libelletEnergie;
    }

    public function setLibelletEnergie(?string $libelletEnergie): static
    {
        $this->libelletEnergie = $libelletEnergie;

        return $this;
    }

    public function getPollutionParKw(): ?float
    {
        return $this->pollutionParKw;
    }

    public function setPollutionParKw(?float $pollutionParKw): static
    {
        $this->pollutionParKw = $pollutionParKw;

        return $this;
    }
}
