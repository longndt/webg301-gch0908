<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
   #[Route('', name: 'category_index')]
   public function categoryIndex() {
       //lấy dữ liệu từ DB
       $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
       //render ra view & gửi kèm dữ liệu từ DB
       return $this->render("category/index.html.twig",
       [
           'category' => $category
       ]);
   }

   #[Route('/detail/{id}', name: 'category_detail')]
   public function categoryDetail($id) {
       $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
       return $this->render("category/detail.html.twig",
       [
           'category' => $category
       ]);
   }

   #[Route('/delete/{id}', name: 'category_delete')]
   public function categoryDelete($id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();
        return $this->redirectToRoute("category_index");
   }

   #[Route('/add', name: 'category_add')]
   public function categoryAdd(Request $request) {
        $category = new Category;
   }

   #[Route('/edit/{id}', name: 'category_edit')]
   public function categoryEdit(Request $request, $id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
   }
}
