<?php

namespace App\Controller;

use App\Entity\CartProduit;
use App\Entity\Produit;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends FOSRestController implements ClassResourceInterface
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
    }

    /**
     * Retrieves a Produit resource
     * @Rest\View()
     * @Rest\Post("/cart/add/{produitId}")
     */
    public function addToCart(Request $request, int $produitId)
    {
        if ($request->isMethod('OPTIONS')) {
            return new Response('ok');
        }
        $em = $this->getDoctrine()->getManager();
        $apiKey = $request->query->get('token');
        $user = $em->getRepository(User::class)->findOneBy(['apiKey' => $apiKey]);
        $cart = $user->getCart();
        $produit = $em->getRepository(Produit::class)->find($produitId);
        $cartProduit = $em->getRepository(CartProduit::class)->findOneBy(['produit' => $produit]);
        if ($cartProduit instanceof CartProduit) {
            $counter = $cartProduit->getCount();
            $cartProduit->setCount($counter + 1);
            $em->persist($cartProduit);
        } else {
            $cartProduit = new CartProduit();
            $cartProduit
                ->setCart($cart)
                ->setProduit($produit)
                ->setCount(1);
            $em->persist($cartProduit);
        }
        $em->flush();
        return View::create($cart, Response::HTTP_OK)->setFormat('json');
    }

    /**
     * Retrieves a Produit resource
     * @Rest\View()
     * @Rest\Post("/cart/remove/{produitId}")
     */
    public function removeFromCart(Request $request, int $produitId)
    {
        if ($request->isMethod('OPTIONS')) {
            return new Response('ok');
        }
        $em = $this->getDoctrine()->getManager();
        $apiKey = $request->query->get('token');
        $user = $em->getRepository(User::class)->findOneBy(['apiKey' => $apiKey]);
        $cart = $user->getCart();
        $produit = $em->getRepository(Produit::class)->find($produitId);
        $cartProduit = $em->getRepository(CartProduit::class)->findOneBy(['produit' => $produit]);
        if ($cartProduit instanceof CartProduit) {
            $counter = $cartProduit->getCount();
            if ($counter > 1) {
                $cartProduit->setCount($counter - 1);
                $em->persist($cartProduit);
            } else {
                $em->remove($cartProduit);
            }
        }
        $em->flush();
        return View::create($cart, Response::HTTP_OK)->setFormat('json');
    }
}
