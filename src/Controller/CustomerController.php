<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/customer', name: 'app_customer')]
class CustomerController extends AbstractController
{
    
    #[Route("/", name: "user_index")]  
    public function userIndex(ManagerRegistry $managerRegistry) {
        $user = $managerRegistry->getRepository(User::class)->findAll();
        if ($user == null) {
            $this->addFlash("Error", "There is no user record yet");
        }
        return $this->render(
            "customer/index.html.twig",
             [
                'Users' => $user
             ]
        );
    }
 
    #[Route("/detail/{id}", name: "user_detail")]
    public function userDetail($id, ManagerRegistry $managerRegistry) {
       $user = $managerRegistry->getRepository(User::class)->find($id);
       if ($user == null) {
          $this->addFlash("Error", "user not found");
          return $this->redirectToRoute("user_index");
       } 
       return $this->render("customer/detail.html.twig",
       [
          'user' => $user
       ]);
    }
 
    #[Route("/delete/{id}", name: "user_delete")]
    public function userDelete ($id, ManagerRegistry $managerRegistry) {
       $user = $managerRegistry->getRepository(user::class)->find($id);
       //TH1: xóa product không tồn tại => báo lỗi
       if ($user == null) {
          $this->addFlash("Error", "user not found !");
       }
      
       else {
          $manager = $managerRegistry->getManager();
          $manager->remove($user);
          $manager->flush();
          $this->addFlash("Success", "Delete user succeed !");
       }
       return $this->redirectToRoute("user_index");
    }

    #[Route("/edit/{id}", name: "user_edit")]
   public function edituser(Request $request, $id , ManagerRegistry $managerRegistry) {
      $user = $managerRegistry->getRepository(User::class)->find($id);
      $form = $this->createForm(UserType::class, $user);
      $form->handleRequest($request);
      $title = "Edit User";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerRegistry->getManager();
         $manager->persist($user);
         $manager->flush();
         $this->addFlash("Success","Edit user succeed !");
         return $this->redirectToRoute("user_index");
      }
      return $this->renderForm("user/edit.html.twig",
      [
         'UserForm' => $form,
         'title' => $title
      ]);
   
}
}
