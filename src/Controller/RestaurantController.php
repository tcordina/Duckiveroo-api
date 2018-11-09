<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


/*
 * @Rest\RouteResource("Restaurants")
 */
class RestaurantController extends FOSRestController implements ClassResourceInterface
{
    private $repository;

    public function __construct(RestaurantRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieves a Restaurant resource
     * @Rest\View()
     * @Rest\Get("/restaurants/{restaurantId}")
     */
    public function getRestaurant(int $restaurantId): View
    {
        $restaurant = $this->repository->findBy(['id' => $restaurantId]);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($restaurant, Response::HTTP_OK)->setFormat('json');
    }

    /**
     * Retrieves a collection of Restaurant resource
     * @Rest\View()
     * @Rest\Get("/restaurants")
     */
    public function getRestaurants(): View
    {
        $restaurants = $this->repository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of restaurant object
        return View::create($restaurants, Response::HTTP_OK);
    }
}
