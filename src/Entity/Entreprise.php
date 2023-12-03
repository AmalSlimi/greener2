<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntrepriseRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idEntreprise = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    #[Assert\Length(max: 150, maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères")]
    private ?string $nom = null;

    #[ORM\Column(length: 25)]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide")]
    #[Assert\Length(max: 25, maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères")]
    private ?string $prenom = null;

    #[ORM\Column(length: 25)]
    private ?string $pdp;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le numéro ne peut pas être vide")]
    #[Assert\Type(type: "integer", message: "Le numéro doit être un entier")]
    private ?int $num;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "L'adresse e-mail ne peut pas être vide")]
    #[Assert\Email(message: "L'adresse e-mail n'est pas valide")]
    private ?string $mail;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide")]
    #[Assert\Length(min: 6, minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères")]
    private ?string $mdp1;

    #[ORM\Column(length: 20)]
    private ?string $role;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "L'adresse ne peut pas être vide")]
    #[Assert\Length(max: 50, maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères")]
    private ?string $adresse;

    #[ORM\Column(length: 30)]
    private ?string $genre;

    #[ORM\Column(length: 200)]
    private ?string $logo;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: "Le nom de l'entreprise ne peut pas être vide")]
    #[Assert\Length(max: 200, maxMessage: "Le nom de l'entreprise ne peut pas dépasser {{ limit }} caractères")]
    private ?string $nomEntreprise;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(message: "Le secteur ne peut pas être vide")]
    #[Assert\Length(max: 40, maxMessage: "Le secteur ne peut pas dépasser {{ limit }} caractères")]
    private ?string $secteur;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide")]
    #[Assert\Length(max: 30, maxMessage: "La description ne peut pas dépasser {{ limit }} caractères")]
    private ?string $description;

    public function getIdEntreprise(): ?int
    {
        return $this->idEntreprise;
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

    public function setPdp(string $pdp): static
    {
        $this->pdp = $pdp;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp1(): ?string
    {
        return $this->mdp1;
    }

    public function setMdp1(string $mdp1): static
    {
        $this->mdp1 = $mdp1;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): static
    {
        $this->secteur = $secteur;

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
}