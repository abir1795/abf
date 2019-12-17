<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BonLivrsnRepository")
 */
class BonLivrsn
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
    private $CommandeId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Address;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $TotalDoc;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="integer")
     */
    private $ClientId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BonlivrsnLine", mappedBy="BonLivrsn")
     */
    private $bonlivrsnLines;

    public function __construct()
    {
        $this->bonlivrsnLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandeId(): ?int
    {
        return $this->CommandeId;
    }

    public function setCommandeId(int $CommandeId): self
    {
        $this->CommandeId = $CommandeId;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getTotalDoc(): ?string
    {
        return $this->TotalDoc;
    }

    public function setTotalDoc(string $TotalDoc): self
    {
        $this->TotalDoc = $TotalDoc;

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

    public function getClientId(): ?int
    {
        return $this->ClientId;
    }

    public function setClientId(int $ClientId): self
    {
        $this->ClientId = $ClientId;

        return $this;
    }

    /**
     * @return Collection|BonlivrsnLine[]
     */
    public function getBonlivrsnLines(): Collection
    {
        return $this->bonlivrsnLines;
    }

    public function addBonlivrsnLine(BonlivrsnLine $bonlivrsnLine): self
    {
        if (!$this->bonlivrsnLines->contains($bonlivrsnLine)) {
            $this->bonlivrsnLines[] = $bonlivrsnLine;
            $bonlivrsnLine->setBonLivrsn($this);
        }

        return $this;
    }

    public function removeBonlivrsnLine(BonlivrsnLine $bonlivrsnLine): self
    {
        if ($this->bonlivrsnLines->contains($bonlivrsnLine)) {
            $this->bonlivrsnLines->removeElement($bonlivrsnLine);
            // set the owning side to null (unless already changed)
            if ($bonlivrsnLine->getBonLivrsn() === $this) {
                $bonlivrsnLine->setBonLivrsn(null);
            }
        }

        return $this;
    }
}
