<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


/*
 * @Rest\RouteResource("Categories")
 */
class CategorieController extends FOSRestController implements ClassResourceInterface
{
    private $repository;

    public function __construct(CategorieRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieves a Categorie resource
     * @Rest\View()
     * @Rest\Get("/categories/{categorieId}")
     */
    public function getCategorie(int $categorieId): View
    {
        $categorie = $this->repository->findBy(['id' => $categorieId]);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($categorie, Response::HTTP_OK)->setFormat('json');
    }

    /**
     * Retrieves a collection of Categorie resource
     * @Rest\View()
     * @Rest\Get("/categories")
     */
    public function getCategories(): View
    {
        $categories = $this->repository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of categorie object
        return View::create($categories, Response::HTTP_OK);
    }
}
