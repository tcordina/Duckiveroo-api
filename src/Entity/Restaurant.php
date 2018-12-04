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
     * @ORM\OneToMany(targetEntity="App\Entity\Categorie", mappedBy="restaurant")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(string $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getGeneralcost(): ?string
    {
        return $this->generalcost;
    }

    public function setGeneralcost(string $generalcost): self
    {
        $this->generalcost = $generalcost;

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

    public function getPrixLivraison(): ?float
    {
        return $this->prixLivraison;
    }

    public function setPrixLivraison(float $prixLivraison): self
    {
        $this->prixLivraison = $prixLivraison;

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

    public function getTempsPrep(): ?int
    {
        return $this->tempsPrep;
    }

    public function setTempsPrep(int $tempsPrep): self
    {
        $this->tempsPrep = $tempsPrep;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setRestaurant($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getRestaurant() === $this) {
                $category->setRestaurant(null);
            }
        }

        return $this;
    }
}
