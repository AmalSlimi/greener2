<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_entreprise", type="integer", nullable=false)
     */
    private $idEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="libellet", type="string", length=225, nullable=false)
     */
    private $libellet;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=false)
     */
    private $img;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="production_mentuelle", type="integer", nullable=false)
     */
    private $productionMentuelle;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_actuelle", type="integer", nullable=false)
     */
    private $stockActuelle;

    /**
     * @var float
     *
     * @ORM\Column(name="pollution_par_piece", type="float", precision=10, scale=0, nullable=false)
     */
    private $pollutionParPiece;


}
