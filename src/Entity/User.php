<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]

    #[ORM\Column(type: "integer")]
    private ?int $idUser = null;

    /*#[ORM\OneToMany(mappedBy: 'user' , targetEntity: Commentaires::class,cascade:["remove"],orphanRemoval:true )]
    private Collection $commentaires;*/

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
        $this->commentaires = new ArrayCollection();
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
     * @return Collection<int, Commentaires>
     */
    /*public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }*/
}
