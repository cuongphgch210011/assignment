<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CustomerType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/user')]
class UserController extends AbstractController
{
   
    
   #[Route("/edit/{id}", name: "user_edit")]
   public function edituser(Request $request, ManagerRegistry $managerRegistry, $id) {
      $user = $managerRegistry->getRepository(User::class)->find($id);
      $form = $this->createForm(CustomerType::class, $user);
      $form->handleRequest($request);
      $title = "Edit user";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerRegistry->getManager();
         $manager->persist($user);
         $manager->flush();
         $this->addFlash("Success","Edit user succeed !");
         return $this->redirectToRoute("home");
      }
      return $this->renderForm("customer/edit.html.twig",
      [
         'userForm' => $form,
         'title' => $title
      ]);
   }
}
