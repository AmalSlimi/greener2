<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Repository\CommandeRepository ;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $commandeId = null;

   
    #[ORM\Column(type: "integer")]
    private ?int $clientId = null;


    #[ORM\ManyToOne(inversedBy: 'commandes', targetEntity: Panier::class)]
    #[ORM\JoinColumn(name: 'panierid', referencedColumnName:'panierid')]
    
    private ?Panier $panier = null;


   

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateCommande = null;

   

    #[ORM\Column]
    private ?float $montantTotal = null ;

    

    #[ORM\Column(length: 500)]
    private ?string $adresseLivraison = null;

   
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateLivraison = null;

    
    #[ORM\Column(length: 500)]
    private ?string $modePaiement = null;

   
    #[ORM\Column(type: "integer")]
    private ?int $panierid = null;

    public function getCommandeId(): ?int
    {
        return $this->commandeId;
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function setClientId(int $clientId): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresseLivraison): static
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $dateLivraison): static
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): static
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getPanierid(): ?int
    {
        return $this->panierid;
    }

    public function setPanierid(int $panierid): static
    {
        $this->panierid = $panierid;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }


}
