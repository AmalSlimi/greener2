<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PanierRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

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

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Commande::class,cascade:["remove"],orphanRemoval:true)]
    private Collection $commande;

    /*#[ORM\ManyToOne(inversedBy: 'panier', targetEntity: Panier::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]
    private ?User $user = null;*/


    #[ORM\Column(type: "integer")]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(length: 255)] 
    #[Assert\NotBlank(message: 'you should enter a valid name')]
    private ?string $nomproduit = null;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commande->contains($commande)) {
            $this->commande->add($commande);
            $commande->setPanier($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getPanier() === $this) {
                $commande->setPanier(null);
            }
        }

        return $this;
    }
    /*
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }*/ }