<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PanierRepository;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $panierid = null;

    #[ORM\Column(type: "integer")]
    private ?int $clientid = null;

    #[ORM\Column(type: "integer")]
    private ?int $produitid = null;

    #[ORM\Column(type: "integer")]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(length: 255)] 
    private ?string $nomproduit = null;

    public function getPanierid(): ?int
    {
        return $this->panierid;
    }

    public function getClientid(): ?int
    {
        return $this->clientid;
    }

    public function setClientid(int $clientid): static
    {
        $this->clientid = $clientid;

        return $this;
    }

    public function getProduitid(): ?int
    {
        return $this->produitid;
    }

    public function setProduitid(int $produitid): static
    {
        $this->produitid = $produitid;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getNomproduit(): ?string
    {
        return $this->nomproduit;
    }

    public function setNomproduit(string $nomproduit): static
    {
        $this->nomproduit = $nomproduit;

        return $this;
    }


}
