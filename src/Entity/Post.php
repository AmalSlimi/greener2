<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Repository\PostRepository;
use Symfony\Component\Validator\Constraints as Assert;




#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idPost = null;

    
    #[ORM\Column(type: "integer")]
    private ?int $idEntreprise = null;

    #[ORM\OneToMany(mappedBy: 'post' , targetEntity: Commentaires::class,cascade:["remove"],orphanRemoval:true )]
    private Collection $commentaires;
    
    #[ORM\Column(length: 50)] 
    #[Assert\NotBlank(message: 'you should enter a title')]
    private ?string $titre = null;

    
    #[ORM\Column(length: 100)] 
    #[Assert\NotBlank(message: 'you should add a type')]
    private ?string $typedecontenu = null;

    
    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'the content should not be empty')]
    private ?string $contenu = null;

    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    
    private ?\DateTimeInterface $date = null;
    

    #[ORM\Column(length: 200)]
    
    private ? string $image = null;

    

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getIdPost(): ?int
    {
        return $this->idPost;
    }

    public function setIdPost(string $idPost): static
    {
        $this->idPost = $idPost;

        return $this;
    }

    public function getIdEntreprise(): ?int
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(string $idEntreprise): static
    {
        $this->idEntreprise = $idEntreprise;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTypedecontenu(): ?string
    {
        return $this->typedecontenu;
    }

    public function setTypedecontenu(string $typedecontenu): static
    {
        $this->typedecontenu = $typedecontenu;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPost($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPost() === $this) {
                $commentaire->setPost(null);
            }
        }

        return $this;
    }


}
