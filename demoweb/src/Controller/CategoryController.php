<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
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
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute("category_index");
        }
        return $this->renderForm('category/add.html.twig',
        [
            'form' => $form
        ]);
   }

   #[Route('/edit/{id}', name: 'category_edit')]
   public function categoryEdit(Request $request, $id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute("category_index");
        }
        return $this->renderForm('category/edit.html.twig',
        [
            'form' => $form
        ]);
   }
}
