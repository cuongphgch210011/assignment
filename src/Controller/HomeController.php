<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Proxies\__CG__\App\Entity\Category;

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
    public function Categoryindex(ProductRepository $productRepository, CategoryRepository $categoryRepossitory, $id) 
    {
        return $this->render('home/index.html.twig', [
            'products' => $productRepository->find($id),
            'categorys'=>$categoryRepossitory->findAll(),
        ]);
    }
}
