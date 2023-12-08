<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Core\User\InMemoryUserProvider;
use Symfony\Component\Security\Core\User\InMemoryUserChecker;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\InMemoryUserProviderInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUser;
use Symfony\Component\Security\Core\User\EquatableTrait;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;





#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['mail'], message: 'There is already an account with this mail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    public ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]

    #[Assert\Length(max: 20, maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères")]
    private ?string $nom = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide")]

    #[Assert\Length(max: 20, maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères")]
    private ?string $prenom = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $pdp = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "Le numéro ne peut pas être vide")]

    #[Assert\Type(type: "integer", message: "Le numéro doit être un entier")]
    private ?int $num;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: "L'adresse e-mail ne peut pas être vide")]

    #[Assert\Email(message: "L'adresse e-mail n'est pas valide")]
    private ?string $mail = "";

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\Length(min: 6, minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères")]
    private ?string $mdp1;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $role = "";

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100, maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères")]
    private ?string $adresse;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $genre;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $investisseurInv = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    /*#[ORM\OneToMany(mappedBy: 'user', targetEntity: Commentaire::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $commentaires;*/

    /*#[ORM\OneToMany(mappedBy: 'user', targetEntity: Panier::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $Paniers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commande::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $Commandes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Evenement::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $Evenements;*/

    /*#[ORM\OneToMany(mappedBy: 'user', targetEntity: investissment::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $investissments;*/



    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        if ($this->getIdUser() !== $user->getIdUser()) {
            return false;
        }

        // Comparez ici les autres propriétés de votre classe User pour déterminer si elles sont égales

        // Exemple de comparaison du nom d'utilisateur
        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }

        // Exemple de comparaison des rôles
        if ($this->getRoles() !== $user->getRoles()) {
            return false;
        }

        // Si toutes les comparaisons précédentes sont réussies, les objets sont égaux
        return true;
    }
    public function getUsername(): string
    {
        // Retourne le nom d'utilisateur (ici, nous utilisons l'adresse e-mail comme nom d'utilisateur)
        return $this->mail ?? '';
    }
    public function getUserIdentifier()
    {
        return $this->getIdUser();
    }
    public function getRoles(): array
    {
        // Retourne les rôles de l'utilisateur sous forme de tableau
        return [$this->role ?? 'ROLE_USER'];
    }
    public function getPassword(): string
    {
        // Retourne le mot de passe de l'utilisateur
        return $this->mdp1 ?? '';
    }
    public function getSalt(): ?string
    {
        // Retourne le sel utilisé pour encoder le mot de passe (peut être null)
        return null;
    }
    public function eraseCredentials(): void
    {
        // Supprime les données sensibles liées à l'authentification de l'utilisateur
        $this->mdp1 = null;
    }


    public function getIdUser(): ?int
    {
        return $this->id;
    }
    public function setIdUser(?int $id): static
    {
        $this->id = $id;
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
        return $this->mail ?? null;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    
}
