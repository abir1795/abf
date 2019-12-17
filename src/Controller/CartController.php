<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 27/11/2019
 * Time: 16:23
 */

namespace App\Controller;


use App\Entity\Favoris;
use App\Repository\FavorisRepository;
use App\Service\Cart\CartsServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
     * @Route("/panier",name="cart_index")
     */
    public function index(CartsServices $cartService)
    {
        return $this->render('cart/cart.html.twig', [
            'items' => $cartService->getFullData(),
            'total' => $cartService->getTotal(),
        ]);
    }

    /**
     * @Route("/panier/add/{id}",name="cart_add")
     */
    public function add($id, CartsServices $cart)
    {
        $cart->add($id);

        return $this->redirectToRoute('cart_index');

    }
    /**
     * @Route("/panier/remove/{id}",name="cart_remove")
     */
    public function removerow($id,CartsServices $cartService){
        $cartService->removerrow($id);
        return $this->redirectToRoute('cart_index');

    }



}