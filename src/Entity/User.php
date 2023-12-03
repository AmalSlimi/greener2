<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idUser = null;

   /* #[ORM\OneToMany(mappedBy: 'user', targetEntity: Panier::class,cascade:["remove"],orphanRemoval:true)]
private Collection $paniers; */

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $pdp = null;

    #[ORM\Column(nullable: true)]
    private ?int $num;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mail;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $mdp1;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $role;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adresse;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $genre;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $investisseurInv = null;

    public function __construct()
    {
        $this->panier = new ArrayCollection();
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }
    public function setIdUser(?int $id): static
    {
        $this->idUser = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPdp(): ?string
    {
        return $this->pdp;
    }

    public function setPdp(?string $pdp): static
    {
        $this->pdp = $pdp;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(?int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp1(): ?string
    {
        return $this->mdp1;
    }

    public function setMdp1(?string $mdp1): static
    {
        $this->mdp1 = $mdp1;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getInvestisseurInv(): ?string
    {
        return $this->investisseurInv;
    }

    public function setInvestisseurInv(?string $investisseurInv): static
    {
        $this->investisseurInv = $investisseurInv;

        return $this;
    }
  
    /**
     * @return Collection<int, Panier>
     */
    public function getPanier(): Collection
    {
        return $this->paniers;
    }
     /*
    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setUser($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getUser() === $this) {
                $panier->setUser(null);
            }
        }

        return $this;
    }  */
}