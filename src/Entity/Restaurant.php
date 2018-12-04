<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $generalcost;

    /**
     * @ORM\Column(type="float", length=10)
     */
    private $likes;

    /**
     * @ORM\Column(type="float", length=10)
     */
    private $prixLivraison;

    /**
     * @ORM\Column(type="float", length=10)
     */
    private $minOrder;

    /**
     * @ORM\Column(type="integer", length=20)
     */
    private $tempsPrep;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="restaurant")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Restaurant
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Restaurant
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Restaurant
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     * @return Restaurant
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Restaurant
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Restaurant
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeneralcost()
    {
        return $this->generalcost;
    }

    /**
     * @param mixed $generalcost
     * @return Restaurant
     */
    public function setGeneralcost($generalcost)
    {
        $this->generalcost = $generalcost;
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
            $produit->setRestaurant($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
            // set the owning side to null (unless already changed)
            if ($produit->getRestaurant() === $this) {
                $produit->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getLikes(): ?float
    {
        return $this->likes;
    }

    public function setLikes(float $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getLivraison(): ?float
    {
        return $this->livraison;
    }

    public function setLivraison(float $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getMinOrder(): ?float
    {
        return $this->minOrder;
    }

    public function setMinOrder(float $minOrder): self
    {
        $this->minOrder = $minOrder;

        return $this;
    }

    public function getPrixLivraison(): ?float
    {
        return $this->prixLivraison;
    }

    public function setPrixLivraison(float $prixLivraison): self
    {
        $this->prixLivraison = $prixLivraison;

        return $this;
    }

    public function getTempsPrep(): ?\DateTimeInterface
    {
        return $this->tempsPrep;
    }

    public function setTempsPrep(\DateTimeInterface $tempsPrep): self
    {
        $this->tempsPrep = $tempsPrep;

        return $this;
    }

}
