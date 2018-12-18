<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController implements ClassResourceInterface
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        header("Access-Control-Allow-Origin: *");
    }

    /**
     * Retrieves a Produit resource
     * @Rest\View()
     * @Rest\Get("/user")
     */
    public function getTheUser(Request $request): View
    {
        $apiKey = $request->query->get('token');
        $user = $this->repository->findOneBy(['apiKey' => $apiKey]);
        return View::create($user, Response::HTTP_OK)->setFormat('json');
    }

    /**
     * Retrieves a Produit resource
     * @Rest\View()
     * @Rest\Route("/user/update", name="user_update", methods={Request::METHOD_POST,Request::METHOD_OPTIONS})
     */
    public function updateTheUser(Request $request)
    {
        if ($request->isMethod('OPTIONS')) {
            return new Response('ok');
        }
        $apiKey = $request->query->get('token');
        $user = $this->repository->findBy(['apiKey' => $apiKey]);
        return View::create($user, Response::HTTP_OK)->setFormat('json');
    }
}
