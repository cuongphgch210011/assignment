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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use function PHPUnit\Framework\throwException;

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
   #[Route('/detail/{id}', name: 'view_product_by_id')]
  

   #[Route("/add", name: "product_add")]
   public function addproduct(Request $request, ManagerRegistry $managerReigistry) {
      $product = new Product;
      $form = $this->createForm(ProductType::class, $product);
      $form->handleRequest($request);
      $title = "Add new product";
      if ($form->isSubmitted() && $form->isValid()) {
         $image = $product->getImage();
            //B2: tạo tên mới cho ảnh => đảm bảo tên ảnh là duy nhất
            $imgName = uniqid(); //unique id
            //B3: lấy đuôi (extension) của file ảnh
            //Note: cần xóa data type "string" trong getter & setter của file Entity
            $imgExtension = $image->guessExtension();
            //B4: tạo tên file hoàn thiện cho ảnh (tên mới + đuôi cũ)
            $imageName = "image/" . $imgName . "." . $imgExtension;
            //B5: di chuyển file ảnh đến thư mục chỉ định ở trong project  
            //Note1: cần tạo thư mục chứa ảnh trong public
            //Note2: cấu hình parameter trong file services.yaml (thư mục config)
             try {
                $image->move (
                    $this->getParameter('product_image'),$imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }
            //B6: lưu tên ảnh vào trong DB
            $product->setImage($imageName);
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
         $imageFile = $form['image']->getData();
                if ($imageFile != null) {
                    //B1: tạo 1 biến để lấy dữ liệu ảnh được upload từ form
                    $image = $product->getImage();
                    //B2: tạo tên mới cho ảnh => đảm bảo tên ảnh là duy nhất
                    $imgName = uniqid(); //unique id
                    //B3: lấy đuôi (extension) của file ảnh
                    //Note: cần xóa data type "string" trong getter & setter của file Entity
                    $imgExtension = $image->guessExtension();
                    //B4: tạo tên file hoàn thiện cho ảnh (tên mới + đuôi cũ)
                    $imageName ="image/" . $imgName . "." . $imgExtension;
                    //B5: di chuyển file ảnh đến thư mục chỉ định ở trong project
                    //Note1: cần tạo thư mục chứa ảnh trong public
                    //Note2: cấu hình parameter trong file services.yaml (thư mục config)
                    try {
                        $image->move(
                            $this->getParameter('product_image'),
                            $imageName
                        );
                    } catch (FileException $e) {
                        throwException($e);
                    }
                    //B6: lưu tên ảnh vào trong DB
                    $product->setImage($imageName);
                }
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
   #[Route('/sortbyname/asc', name: 'sort_product_name_ascending')]
    public function ProductSortAscending(ProductRepository $productRepository) {
        $products = $productRepository->sortByNameAscending();
        return $this->render(
            "product/index.html.twig",
            [
                'products' => $products
            ]);
    }

    #[Route('/sortbyname/desc', name: 'sort_product_name_descending')]
    public function ProductSortDescending(ProductRepository $productRepository) {
        $products = $productRepository->sortByNameDescending();
        return $this->render(
            "product/index.html.twig",
            [
                'products' => $products
            ]);
    }

    #[Route('/searchbyname', name: 'search_product_name')]
    public function ProductSearchByName (ProductRepository $productRepository, Request $request) {
        $name = $request->get('keyword');
        $products = $productRepository->searchByName($name);
        return $this->render(
            "product/index.html.twig",
            [
                'products' => $products
            ]);
    }
}