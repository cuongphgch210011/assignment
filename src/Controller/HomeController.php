<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepossitory) 
    {
        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findAll(),
            'categorys'=>$categoryRepossitory->findAll(),
        ]);
    }
    
    #[Route('/category/{id}', name: 'categorysort')]
    public function Categoryindex(Request $request,ProductRepository $productRepository, CategoryRepository $categoryRepossitory,$id) 
    {     $category = $productRepository->showByCategory($id);
        return $this->render('home/index.html.twig', [
          
            'products' => $category,
            'categorys'=>$categoryRepossitory->findAll(),
        ]);
    }
}
