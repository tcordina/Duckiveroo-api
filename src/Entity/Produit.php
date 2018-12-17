<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartProduit", mappedBy="produit", fetch="EAGER")
     */
    private $cartProduit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="produits")
     */
    private $categorie;

    /**
     * @ORM\Column(type="float", length=10)
     */
    private $price;

    public function __construct()
    {
        $this->cartProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|CartProduit[]
     */
    public function getCartProduit(): Collection
    {
        return $this->cartProduit;
    }

    public function addCartProduit(CartProduit $cartProduit): self
    {
        if (!$this->cartProduit->contains($cartProduit)) {
            $this->cartProduit[] = $cartProduit;
            $cartProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCartProduit(CartProduit $cartProduit): self
    {
        if ($this->cartProduit->contains($cartProduit)) {
            $this->cartProduit->removeElement($cartProduit);
            // set the owning side to null (unless already changed)
            if ($cartProduit->getProduit() === $this) {
                $cartProduit->setProduit(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
