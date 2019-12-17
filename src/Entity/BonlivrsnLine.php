<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BonlivrsnLineRepository")
 */
class BonlivrsnLine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BonLivrsn", inversedBy="bonlivrsnLines")
     */
    private $BonLivrsn;

    /**
     * @ORM\Column(type="integer")
     */
    private $ProduitId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ProduitNom;

    /**
     * @ORM\Column(type="integer")
     */
    private $Qty;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $Prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBonLivrsn(): ?BonLivrsn
    {
        return $this->BonLivrsn;
    }

    public function setBonLivrsn(?BonLivrsn $BonLivrsn): self
    {
        $this->BonLivrsn = $BonLivrsn;

        return $this;
    }

    public function getProduitId(): ?int
    {
        return $this->ProduitId;
    }

    public function setProduitId(int $ProduitId): self
    {
        $this->ProduitId = $ProduitId;

        return $this;
    }

    public function getProduitNom(): ?string
    {
        return $this->ProduitNom;
    }

    public function setProduitNom(string $ProduitNom): self
    {
        $this->ProduitNom = $ProduitNom;

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

    public function getPrix(): ?string
    {
        return $this->Prix;
    }

    public function setPrix(string $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }
}
