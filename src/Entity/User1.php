<?php

namespace App\Entity;

use App\Repository\User1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
#[ORM\Entity(repositoryClass: User1Repository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User1 implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Evenement::class)]
    private Collection $evenements;
    

    
    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'participants')]
    private Collection $participated_evenements;
    
    /*#[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'participants')]
    #[JoinTable(name: 'evenement_user1')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private Collection $participated_evenements;*/
    
    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->participated_evenements = new ArrayCollection();
    }

    public const ROLE_ENTREPRISE = 'ROLE_ENTREPRISE';
    public const ROLE_INVESTISSEUR = 'ROLE_INVESTISSEUR';
    public const ROLE_LIVREUR = 'ROLE_LIVREUR';
    public const ROLE_USER = 'ROLE_USER';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user1.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles ?? [];
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed if you are not using a modern
     * hashing algorithm (e.g., bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user1, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setEntreprise($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getEntreprise() === $this) {
                $evenement->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getParticipatedEvenements(): Collection
    {
        return $this->participated_evenements;
    }

    public function addParticipatedEvenement(Evenement $participatedEvenement): static
    {
        if (!$this->participated_evenements->contains($participatedEvenement)) {
            $this->participated_evenements->add($participatedEvenement);
            $participatedEvenement->addParticipant($this);
        }

        return $this;
    }

    public function removeParticipatedEvenement(Evenement $participatedEvenement): static
    {
        if ($this->participated_evenements->removeElement($participatedEvenement)) {
            $participatedEvenement->removeParticipant($this);
        }

        return $this;
    }
}
