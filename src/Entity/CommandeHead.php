<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeHeadRepository")
 */
class CommandeHead
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $CommandeTotal;

    /**
     * @ORM\Column(type="integer")
     */
    private $User_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="CommandeHead")
     */
    private $commandes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;



    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->DateCreate;
    }

    public function setDateCreate(\DateTimeInterface $DateCreate): self
    {
        $this->DateCreate = $DateCreate;

        return $this;
    }

    public function getCommandeTotal(): ?string
    {
        return $this->CommandeTotal;
    }

    public function setCommandeTotal(string $CommandeTotal): self
    {
        $this->CommandeTotal = $CommandeTotal;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->User_id;
    }

    public function setUserId(int $User_id): self
    {
        $this->User_id = $User_id;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setCommandeHead($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getCommandeHead() === $this) {
                $commande->setCommandeHead(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }


}
