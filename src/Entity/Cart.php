<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartProduit", mappedBy="cart", fetch="EAGER")
     */
    private $cartProduit;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart")
     */
    private $user;

    public function __construct()
    {
        $this->cartProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $cartProduit->setCart($this);
        }

        return $this;
    }

    public function removeCartProduit(CartProduit $cartProduit): self
    {
        if ($this->cartProduit->contains($cartProduit)) {
            $this->cartProduit->removeElement($cartProduit);
            // set the owning side to null (unless already changed)
            if ($cartProduit->getCart() === $this) {
                $cartProduit->setCart(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
