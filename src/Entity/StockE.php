<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockERepository")
 *
 */
class StockE
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Produit", inversedBy="stockProduit")
     * @ORM\JoinColumn(name="prdouits_id", referencedColumnName="id")
     */
    private $prdouits;
    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $Qty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrdouits(): ?Produit
    {
        return $this->prdouits;
    }

    public function setPrdouits(?Produit $prdouits): self
    {
        $this->prdouits = $prdouits;

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
}
