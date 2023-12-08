<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelletProduit = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;
    #[ORM\Column(nullable: true)]
    private ?int $productionMentuelle = null;

    #[ORM\Column(nullable: true)]
    private ?int $stockActuelle = null;

    #[ORM\Column(nullable: true)]
    private ?float $pollutionParPiece = null;

    #[ORM\ManyToOne]
    private ?Categorie $categorie = null;
    #[ORM\ManyToOne]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne]
    private ?Energie $typeEnergie = null;

    #[ORM\ManyToOne]
    private ?Vehicule $typeVehicule = null;

    #[ORM\Column(nullable: true)]
    private ?float $consommationrnEnergie = null;

    #[ORM\Column]
    private ?float $distanceVehicule = null;
    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getIdProduit(): ?int
    {
        return $this->id;
    }

    public function getLibelletProduit(): ?string
    {
        return $this->libelletProduit;
    }

    public function setLibelletProduit(?string $libelletProduit): static
    {
        $this->libelletProduit = $libelletProduit;

        return $this;
    }
    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getProductionMentuelle(): ?int
    {
        return $this->productionMentuelle;
    }

    public function setProductionMentuelle(?int $productionMentuelle): static
    {
        $this->productionMentuelle = $productionMentuelle;

        return $this;
    }

    public function getStockActuelle(): ?int
    {
        return $this->stockActuelle;
    }

    public function setStockActuelle(?int $stockActuelle): static
    {
        $this->stockActuelle = $stockActuelle;

        return $this;
    }

    public function getPollutionParPiece(): ?float
    {
        return $this->pollutionParPiece;
    }

    public function setPollutionParPiece(?float $pollutionParPiece): static
    {
        /*$typener=$this->getTypeEnergie();
        $typveh=$this->getTypeVehicule();
        $ener=$typener->getPollutionParKw();
        $veh=$typveh->getPollutioParKm();
        $pol= (($this->getConsommationrnEnergie()*$ener)+($this->getDistanceVehicule()*$veh))/$this->getProductionMentuelle();
        $this->pollutionParPiece = $pol;*/
        $this->pollutionParPiece = $pollutionParPiece;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getTypeEnergie(): ?Energie
    {
        return $this->typeEnergie;
    }

    public function setTypeEnergie(?Energie $typeEnergie): static
    {
        $this->typeEnergie = $typeEnergie;

        return $this;
    }

    public function getTypeVehicule(): ?Vehicule
    {
        return $this->typeVehicule;
    }

    public function setTypeVehicule(?Vehicule $typeVehicule): static
    {
        $this->typeVehicule = $typeVehicule;

        return $this;
    }

    public function getConsommationrnEnergie(): ?float
    {
        return $this->consommationrnEnergie;
    }

    public function setConsommationrnEnergie(?float $consommationrnEnergie): static
    {
        $this->consommationrnEnergie = $consommationrnEnergie;

        return $this;
    }

    public function getDistanceVehicule(): ?float
    {
        return $this->distanceVehicule;
    }

    public function setDistanceVehicule(float $distanceVehicule): static
    {
        $this->distanceVehicule = $distanceVehicule;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }
}
