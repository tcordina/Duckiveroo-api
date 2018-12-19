<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartProduit;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\DBAL\DBALException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends FOSRestController implements ClassResourceInterface
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
    }

    /**
     * @Rest\Route("/cart/add/{produitId}", name="cart_add", methods={Request::METHOD_POST,Request::METHOD_OPTIONS,Request::METHOD_GET})
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
        if ($cart === null) {
            $cart = new Cart();
            $user->setCart($cart);
            $em->persist($cart);
        }
        $produit = $em->getRepository(Produit::class)->find($produitId);
        $cartProduit = $em->getRepository(CartProduit::class)->findOneBy(['cart' => $cart, 'produit' => $produit]);
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
        try {
            $em->flush();
            return new JsonResponse(true);
        } catch (DBALException $e) {
            return new JsonResponse($e);
        }
    }

    /**
     * Retrieves a Produit resource
     * @Rest\Route("/cart/remove/{produitId}", name="cart_remove", methods={Request::METHOD_POST,Request::METHOD_OPTIONS,Request::METHOD_GET})
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
        $cartProduit = $em->getRepository(CartProduit::class)->findOneBy(['cart' => $cart, 'produit' => $produit]);
        if ($cartProduit instanceof CartProduit) {
            $counter = $cartProduit->getCount();
            if ($counter > 1) {
                $cartProduit->setCount($counter - 1);
                $em->persist($cartProduit);
            } else {
                $em->remove($cartProduit);
            }
        } else {
            return new JsonResponse(false);
        }
        try {
            $em->flush();
            return new JsonResponse(true);
        } catch (DBALException $e) {
            return new JsonResponse($e);
        }
    }
}
