<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InvestissementRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvestissementRepository::class)]
class Investissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idInvestissement = null;

    #[ORM\Column]
    private ?int $idInvestisseur = null;

    #[ORM\Column]
    private ?int $idEntreprise = null;
  
    #[ORM\Column]
    private ?float $montant = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebutInvestissement = null;
    
    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "vous devez mettre votre duree prevue!!!")]
    private ?string $dureePrevue = null;


    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "vous devez mettre votre details!!!")]
    private ?string $details = null;
    
    #[ORM\Column]
    private ?int $status = null;

    /*#[ORM\ManyToOne(inversedBy: 'investissment', targetEntity: investissment::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]
    private ?User $user = null;*/
    
    public function getIdInvestissement(): ?int
    {
        return $this->idInvestissement;
    }

    public function getIdInvestisseur(): ?int
    {
        return $this->idInvestisseur;
    }

    public function setIdInvestisseur(int $idInvestisseur): static
    {
        $this->idInvestisseur = $idInvestisseur;

        return $this;
    }

    public function getIdEntreprise(): ?int
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(int $idEntreprise): static
    {
        $this->idEntreprise = $idEntreprise;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDebutInvestissement(): ?\DateTimeInterface
    {
        return $this->dateDebutInvestissement;
    }

    public function setDateDebutInvestissement(\DateTimeInterface $dateDebutInvestissement): static
    {
        $this->dateDebutInvestissement = $dateDebutInvestissement;

        return $this;
    }

    public function getDureePrevue(): ?string
    {
        return $this->dureePrevue;
    }

    public function setDureePrevue(string $dureePrevue): static
    {
        $this->dureePrevue = $dureePrevue;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }



}