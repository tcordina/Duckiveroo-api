<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartProduitController extends AbstractController
{
    /**
     * @Route("/cart/produit", name="cart_produit")
     */
    public function index()
    {
        return $this->render('cart_produit/index.html.twig', [
            'controller_name' => 'CartProduitController',
        ]);
    }
}
