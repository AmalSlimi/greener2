<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[Vich\Uploadable]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Vich\UploadableField(mapping="file_upload", fileNameProperty="image_file")
     */
    private ?File $image = null;
    
    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "vous devez mettre votre titre !!!")]
    private ?string $titreEvenement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateEvenementt = null;
    
    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "vous devez mettre votre qrcode !!!")]
    private ?string $qrcode = null;

    #[ORM\Column(length: 500)]
    private ?string $imageEvenement = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "vous devez mettre votre lieu!!!")]
    private ?string $lieuEvenement= null;
    
    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "vous devez mettre votre description!!!")]
    private ?string $descriptionEvenement= null;

    /*#[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User1 $entreprise = null;*/

    
    #[ORM\ManyToMany(targetEntity: User1::class, inversedBy: 'participated_evenements')]
    private Collection $participants;

    /*#[ORM\ManyToOne(inversedBy: 'evenement', targetEntity: Evenement::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]
    private ?User $user = null;*/


    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(name: 'entreprise_id', referencedColumnName: 'id', nullable: false)]
    private ?User1 $entreprise = null;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreEvenement(): ?string
    {
        return $this->titreEvenement;
    }

    public function setTitreEvenement(string $titreEvenement): static
    {
        $this->titreEvenement = $titreEvenement;

        return $this;
    }

    public function getDateEvenementt(): ?\DateTimeInterface
    {
        return $this->dateEvenementt;
    }

    public function setDateEvenementt(\DateTimeInterface $dateEvenementt): static
    {
        $this->dateEvenementt = $dateEvenementt;

        return $this;
    }

    public function getQrcode(): ?string
    {
        return $this->qrcode;
    }

    public function setQrcode(string $qrcode): static
    {
        $this->qrcode = $qrcode;

        return $this;
    }

    public function getImageEvenement(): ?string
    {
        return $this->imageEvenement;
    }

    public function setImageEvenement(string $imageEvenement): static
    {
        $this->imageEvenement = $imageEvenement;

        return $this;
    }

    public function getLieuEvenement(): ?string
    {
        return $this->lieuEvenement;
    }

    public function setLieuEvenement(string $lieuEvenement): static
    {
        $this->lieuEvenement = $lieuEvenement;

        return $this;
    }

    public function getDescriptionEvenement(): ?string
    {
        return $this->descriptionEvenement;
    }

    public function setDescriptionEvenement(string $descriptionEvenement): static
    {
        $this->descriptionEvenement = $descriptionEvenement;

        return $this;
    }

    public function getEntreprise(): ?User1
    {
        return $this->entreprise;
    }

    public function setEntreprise(?User1 $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, User1>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User1 $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(User1 $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }


}
