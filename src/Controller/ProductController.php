<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route("/product")]
class ProductController extends AbstractController
{
   #[Route("/", name: "product_index")]  
   public function productIndex(ManagerRegistry $managerRegistry) {
       $products = $managerRegistry->getRepository(Product::class)->findAll();
       if ($products == null) {
           $this->addFlash("Error", "There is no product record yet");
       }
       return $this->render(
           "product/index.html.twig",
            [
               'products' => $products
            ]
       );
   }

   #[Route("/detail/{id}", name: "product_detail")]
   public function productDetail($id, ManagerRegistry $managerRegistry) {
      $product = $managerRegistry->getRepository(Product::class)->find($id);
      if ($product == null) {
         $this->addFlash("Error", "product not found");
         return $this->redirectToRoute("product_index");
      } 
      return $this->render("product/detail.html.twig",
      [
         'product' => $product
      ]);
   }

   #[Route("/delete/{id}", name: "product_delete")]
   public function productDelete ($id, ManagerRegistry $managerRegistry) {
      $product = $managerRegistry->getRepository(product::class)->find($id);
      //TH1: xóa product không tồn tại => báo lỗi
      if ($product == null) {
         $this->addFlash("Error", "Product not found !");
      }
     
      //TH3: product có tồn tại và không còn liên kết với todo => xóa khỏi DB và trả về thông báo
      else {
         $manager = $managerRegistry->getManager();
         $manager->remove($product);
         $manager->flush();
         $this->addFlash("Success", "Delete product succeed !");
      }
      return $this->redirectToRoute("product_index");
   }

   #[Route("/add", name: "product_add")]
   public function addproduct(Request $request, ManagerRegistry $managerReigistry) {
      $product = new Product;
      $form = $this->createForm(ProductType::class, $product);
      $form->handleRequest($request);
      $title = "Add new product";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerReigistry->getManager();
         $manager->persist($product);
         $manager->flush();
         $this->addFlash("Success","Add product succeed !");
         return $this->redirectToRoute("product_index");
      }
      return $this->renderForm("product/save.html.twig",
      [
         'productForm' => $form,
         'title' => $title
      ]);
   }

   #[Route("/edit/{id}", name: "product_edit")]
   public function editproduct(Request $request, ManagerRegistry $managerRegistry, $id) {
      $product = $managerRegistry->getRepository(Product::class)->find($id);
      $form = $this->createForm(ProductType::class, $product);
      $form->handleRequest($request);
      $title = "Edit product";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerRegistry->getManager();
         $manager->persist($product);
         $manager->flush();
         $this->addFlash("Success","Edit product succeed !");
         return $this->redirectToRoute("product_index");
      }
      return $this->renderForm("product/save.html.twig",
      [
         'productForm' => $form,
         'title' => $title
      ]);
   }
}