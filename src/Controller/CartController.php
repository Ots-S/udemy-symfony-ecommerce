<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(Cart $cart): Response
    {
        $cart->get();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->get(),
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */

    public function add(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/cart/remove/{id}", name="remove_my_cart")
     */

    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('products');
    }
}
