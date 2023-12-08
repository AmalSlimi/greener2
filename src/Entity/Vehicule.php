<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
#[UniqueEntity('LibelletVehicule')]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $LibelletVehicule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MarqueVehicule = null;

    #[ORM\Column(nullable: true)]
    private ?float $PollutioParKm = null;

    public function getIdVehicule(): ?int
    {
        return $this->id;
    }

    public function getLibelletVehicule(): ?string
    {
        return $this->LibelletVehicule;
    }

    public function setLibelletVehicule(?string $Libellet): static
    {
        $this->LibelletVehicule = $Libellet;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->MarqueVehicule;
    }

    public function setMarque(?string $Marque): static
    {
        $this->MarqueVehicule = $Marque;

        return $this;
    }

    public function getPollutioParKm(): ?float
    {
        return $this->PollutioParKm;
    }

    public function setPollutioParKm(?float $PollutioParKm): static
    {
        $this->PollutioParKm = $PollutioParKm;

        return $this;
    }
}
