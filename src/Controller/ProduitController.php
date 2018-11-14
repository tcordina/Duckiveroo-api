<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


/*
 * @Rest\RouteResource("Produits")
 */
class ProduitController extends FOSRestController implements ClassResourceInterface
{
    private $repository;

    public function __construct(ProduitRepository $repository)
    {
        $this->repository = $repository;
        header("Access-Control-Allow-Origin: *");
    }

    /**
     * Retrieves a Produit resource
     * @Rest\View()
     * @Rest\Get("/produits/{produitId}")
     */
    public function getProduit(int $produitId): View
    {
        $produit = $this->repository->findBy(['id' => $produitId]);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($produit, Response::HTTP_OK)->setFormat('json');
    }

    /**
     * Retrieves a collection of Produit resource
     * @Rest\View()
     * @Rest\Get("/produits")
     */
    public function getProduits(): View
    {
        $produits = $this->repository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of produit object
        return View::create($produits, Response::HTTP_OK);
    }
}
