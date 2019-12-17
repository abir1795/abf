<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")

 * @UniqueEntity(fields="Produit_Code" ,message="Code Produit déja utilise !!!")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Produit_Code;

    /**
     * @ORM\Column(type="boolean")
     */
    private $HOLD;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     *
     * @Assert\Range(min=0, max=1005000)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ImageUrl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StockE", mappedBy="prdouits", cascade={"persist", "remove"})
     */
    private $stockProduit;

    /**
     * @ORM\Column(type="text")
     */
    private $DescriptionText;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getProduitCode(): ?string
    {
        return $this->Produit_Code;
    }

    public function setProduitCode(string $Produit_Code): self
    {
        $this->Produit_Code = $Produit_Code;

        return $this;
    }

    public function getHOLD(): ?bool
    {
        return $this->HOLD;
    }

    public function setHOLD(bool $HOLD): self
    {
        $this->HOLD = $HOLD;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->ImageUrl;
    }

    public function setImageUrl(string $ImageUrl): self
    {
        $this->ImageUrl = $ImageUrl;

        return $this;
    }

    public function getCategory(): ?Categorie
    {
        return $this->category;
    }

    public function setCategory(?Categorie $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStockProduit(): ?StockE
    {
        return $this->stockProduit;
    }

    public function setStockProduit(?StockE $stockProduit): self
    {
        $this->stockProduit = $stockProduit;

        return $this;
    }

    public function getDescriptionText(): ?string
    {
        return $this->DescriptionText;
    }

    public function setDescriptionText(string $DescriptionText): self
    {
        $this->DescriptionText = $DescriptionText;

        return $this;
    }


}
