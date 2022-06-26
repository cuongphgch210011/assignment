<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
#[Route("/cart")]
class OrderDetailController extends AbstractController
{
    #[Route("/", name: "cart_index")]  
   public function cartIndex(ManagerRegistry $managerRegistry) {
       $carts = $managerRegistry->getRepository(OrderDetail::class)->findAll();
       if ($carts == null) {
           $this->addFlash("Error", "There is no product record yet");
       }
       return $this->render(
           "cart/index.html.twig",
            [
               'carts' => $carts
            ]
       );
   }

   #[Route("/delete/{id}", name: "cart_delete")]
   public function cartDelete ($id, ManagerRegistry $managerRegistry) {
      $cart = $managerRegistry->getRepository(OrderDetail::class)->find($id);
      if ($cart == null) {
         $this->addFlash("Error", "product not found !");
      }
     
      else {
         $manager = $managerRegistry->getManager();
         $manager->remove($cart);
         $manager->flush();
         $this->addFlash("Success", "Delete product from cart succeed !");
      }
      return $this->redirectToRoute("cart_index");
   }

   #[Route("/add", name: "cart_add")]
   public function addcart(Request $request,ManagerRegistry $managerRegistry) {
      $orderdetail = new OrderDetail;
      $form = $this->createForm(OrderDetailType::class, $orderdetail);
      $form->handleRequest($request);
      $title = "Add new product to cart";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerRegistry->getManager();
         $manager->persist($orderdetail);
         $manager->flush();
         $this->addFlash("Success","Add product to cart succeed !");
         return $this->redirectToRoute("cart_index");
      }
      return $this->renderForm("cart/add.html.twig",
      [
         'cartForm' => $form
      ]);
   }
}
