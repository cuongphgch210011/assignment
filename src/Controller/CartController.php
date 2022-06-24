<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Entity\Product;
use App\Form\CartType;
use App\Repository\CustomerRepository;
use App\Repository\OrderDetailRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'cart')]
    public function CartIndex()
    {
        $cart = $this->cart->getItems();

        return $this->render('cart/index.html.twig', ['cart' => $cart]);
    }

    #[Route('/clear', name: 'clear_cart')]
    public function ClearCart()
    {
        $this->cart->clear();

        $this->addFlash('success', 'Cart cleared');

        return $this->redirectToRoute('homepage');
    }
    #[Route('/add', name: 'add_cart')]
    public function addToCartAction(Product $product)
    {
        $item = new OrderDetail([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
        ]);
        $item->setQuantity(1); // defaults to 1
        $this->cart->addItem($item);

        $this->addFlash('success', 'Product added to cart successfully.');

        return $this->redirectToRoute('home');
    }
}
