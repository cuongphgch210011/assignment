<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\OrderDetailType;

class ProductdetailController extends AbstractController
{
    #[Route('/productdetail/{id}', name: 'product_detail')]
    public function index(Product $product,Request $request): Response
    {
        $form = $this->createForm(OrderDetailType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProduct($product);


            return $this->redirectToRoute('product_detail', ['id' => $product->getId()]);
        }

        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}
