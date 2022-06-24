<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/category")]
class CategoryController extends AbstractController
{
   #[Route("/", name: "category_index")]  
   public function categoryIndex(ManagerRegistry $managerRegistry) {
       $categorys = $managerRegistry->getRepository(Category::class)->findAll();
       if ($categorys == null) {
           $this->addFlash("Error", "There is no category record yet");
       }
       return $this->render(
           "category/index.html.twig",
            [
               'categorys' => $categorys
            ]
       );
   }

   #[Route("/detail/{id}", name: "category_detail")]
   public function categoryDetail($id, ManagerRegistry $managerRegistry) {
      $category = $managerRegistry->getRepository(Category::class)->find($id);
      if ($category == null) {
         $this->addFlash("Error", "category not found");
         return $this->redirectToRoute("category_index");
      } 
      return $this->render("category/detail.html.twig",
      [
         'category' => $category
      ]);
   }

   #[Route("/delete/{id}", name: "category_delete")]
   public function categoryDelete ($id, ManagerRegistry $managerRegistry) {
      $category = $managerRegistry->getRepository(Category::class)->find($id);
      //TH1: xóa category không tồn tại => báo lỗi
      if ($category == null) {
         $this->addFlash("Error", "category not found !");
      }
     
      //TH3: category có tồn tại và không còn liên kết với todo => xóa khỏi DB và trả về thông báo
      else {
         $manager = $managerRegistry->getManager();
         $manager->remove($category);
         $manager->flush();
         $this->addFlash("Success", "Delete category succeed !");
      }
      return $this->redirectToRoute("category_index");
   }

   #[Route("/add", name: "category_add")]
   public function addcategory(Request $request) {
      $category = new Category;
      $form = $this->createForm(CategoryType::class, $category);
      $form->handleRequest($request);
      $title = "Add new category";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($category);
         $manager->flush();
         $this->addFlash("Success","Add category succeed !");
         return $this->redirectToRoute("category_index");
      }
      return $this->renderForm("category/save.html.twig",
      [
         'categoryForm' => $form,
         'title' => $title
      ]);
   }

   #[Route("/edit/{id}", name: "category_edit")]
   public function editcategory(Request $request, $id, ManagerRegistry $managerRegistry) {
      $category = $managerRegistry->getRepository(Category::class)->find($id);
      $form = $this->createForm(CategoryType::class, $category);
      $form->handleRequest($request);
      $title = "Edit category";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerRegistry->getManager();
         $manager->persist($category);
         $manager->flush();
         $this->addFlash("Success","Edit category succeed !");
         return $this->redirectToRoute("category_index");
      }
      return $this->renderForm("category/save.html.twig",
      [
         'categoryForm' => $form,
         'title' => $title
      ]);
   }
}