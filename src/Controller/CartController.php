<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Form\CartType;
use App\Repository\OrderDetailRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'cart')]
    public function CartIndex(OrderDetailRepository $cartRepository)
    {
        $carts = $cartRepository->findAll();
        return $this->render(
            "cart/index.html.twig",
        [
            'carts' => $carts
        ]
        );
    }

    #[Route('/add', name: 'add_cart')]
    public function CartAdd(Request $request, ManagerRegistry $managerRegistry){
        $cart = new OrderDetail;
        $form = $this->createForm(CartType::class,$cart);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($cart);
            $manager->flush();
            $this->addFlash("Success","Added to cart !");
            return $this->redirectToRoute("cart");
        }
        return $this->render("cart/add.html.twig",
        [
            'cartForm' => $form->createView()
        ]);
    }
}
