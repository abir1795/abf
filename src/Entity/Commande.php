<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Product_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Product_Name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $Product_Price;

    /**
     * @ORM\Column(type="integer")
     */
    private $Qty;

    /**
     * @ORM\Column(type="integer")
     */
    private $User_Id;

    /**
     * @ORM\Column(type="text")
     */
    private $Address_Shipement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date_Creation;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $TotalLine;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $TotalCommande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommandeHead", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $CommandeHead;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->Product_id;
    }

    public function setProductId(int $Product_id): self
    {
        $this->Product_id = $Product_id;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->Product_Name;
    }

    public function setProductName(string $Product_Name): self
    {
        $this->Product_Name = $Product_Name;

        return $this;
    }

    public function getProductPrice(): ?string
    {
        return $this->Product_Price;
    }

    public function setProductPrice(string $Product_Price): self
    {
        $this->Product_Price = $Product_Price;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->Qty;
    }

    public function setQty(int $Qty): self
    {
        $this->Qty = $Qty;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->User_Id;
    }

    public function setUserId(int $User_Id): self
    {
        $this->User_Id = $User_Id;

        return $this;
    }

    public function getAddressShipement(): ?string
    {
        return $this->Address_Shipement;
    }

    public function setAddressShipement(string $Address_Shipement): self
    {
        $this->Address_Shipement = $Address_Shipement;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->Date_Creation;
    }

    public function setDateCreation(\DateTimeInterface $Date_Creation): self
    {
        $this->Date_Creation = $Date_Creation;

        return $this;
    }

    public function getTotalLine(): ?string
    {
        return $this->TotalLine;
    }

    public function setTotalLine(string $TotalLine): self
    {
        $this->TotalLine = $TotalLine;

        return $this;
    }

    public function getTotalCommande(): ?string
    {
        return $this->TotalCommande;
    }

    public function setTotalCommande(string $TotalCommande): self
    {
        $this->TotalCommande = $TotalCommande;

        return $this;
    }

    public function getCommandeHead(): ?CommandeHead
    {
        return $this->CommandeHead;
    }

    public function setCommandeHead(?CommandeHead $CommandeHead): self
    {
        $this->CommandeHead = $CommandeHead;

        return $this;
    }
}
