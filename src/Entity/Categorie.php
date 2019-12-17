<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 * @UniqueEntity(fields="Name_Categorie" ,message="Nom déja utilise !!!")
 *
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=5,max=50,minMessage="votre Nom et dois etres entre  2 et 20 caractere")
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $Name_Categorie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $HOLD;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="category")
     */
    private $produits;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ImageUrl;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCategorie(): ?string
    {
        return $this->Name_Categorie;
    }

    public function setNameCategorie(string $Name_Categorie): self
    {
        $this->Name_Categorie = $Name_Categorie;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCategory($this);
        }

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




}
