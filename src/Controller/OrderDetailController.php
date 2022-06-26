<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use App\Repository\OrderDetailRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route("/cart")]
class OrderDetailController extends AbstractController
{
    #[Route("/", name: "cart_index")]  
   public function cartIndex(ManagerRegistry $managerRegistry) {
       $orderdetails = $managerRegistry->getRepository(OrderDetail::class)->findAll();
       if ($orderdetails == null) {
           $this->addFlash("Error", "There is no product record yet");
       }
       return $this->render(
           "cart/index.html.twig",
            [
               'orderdetails' => $orderdetails
            ]
       );
   }

   #[Route('/detail/{id}', name: 'cart_detail')]
    public function CourseDetail(OrderDetailRepository $orderDetailRepository, $id)
    {
        $orderdetail = $orderDetailRepository->find($id);
        return $this->render(
            "cart/detail.html.twig",
        [
            'orderdetail' => $orderdetail
        ]
        );
    }

   #[Route("/delete/{id}", name: "cart_delete")]
   public function cartDelete ($id, ManagerRegistry $managerRegistry) {
      $orderdetail = $managerRegistry->getRepository(OrderDetail::class)->find($id);
      if ($orderdetail == null) {
         $this->addFlash("Error", "product not found !");
      }
     
      else {
         $manager = $managerRegistry->getManager();
         $manager->remove($orderdetail);
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
         'orderdetailForm' => $form
      ]);
   }

   #[Route("/edit/{id}", name: "cart_edit")]
   public function editproduct(Request $request, $id , ManagerRegistry $managerRegistry) {
      $orderdetail = $managerRegistry->getRepository(OrderDetail::class)->find($id);
      $form = $this->createForm(OrderDetailType::class, $orderdetail);
      $form->handleRequest($request);
      $title = "Edit cart";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerRegistry->getManager();
         $manager->persist($orderdetail);
         $manager->flush();
         $this->addFlash("Success","Edit cart succeed !");
         return $this->redirectToRoute("cart_index");
      }
      return $this->renderForm("cart/edit.html.twig",
      [
         'orderdetailForm' => $form
      ]);
   }
}
