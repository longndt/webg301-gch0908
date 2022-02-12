<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genre')]
class GenreController extends AbstractController
{
   #[Route('', name: 'genre_index')]
   public function genreIndex() {
       $genre = $this->getDoctrine()->getRepository(Genre::class)->findAll();
       return $this->render("genre/index.html.twig",
       [
           'genres' => $genre
       ]);
   }

   #[Route('/detail/{id}', name: 'genre_detail')]
   public function genreDetail($id) {
       $genre = $this->getDoctrine()->getRepository(Genre::class)->find($id);
       return $this->render("genre/detail.html.twig",
       [
           'genre' => $genre
       ]);
   }

   #[Route('/delete/{id}', name: 'genre_delete')]
   public function genreDelete($id) {
        $genre = $this->getDoctrine()->getRepository(Genre::class)->find($id);
        if (count($genre->getMovies())==0 ) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($genre);
            $manager->flush();
        }
        return $this->redirectToRoute("genre_index");
   }

   #[Route('/add', name: 'genre_add')]
   public function genreAdd(Request $request) {
      $genre = new Genre;  
      $form = $this->createForm(GenreType::class,$genre);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($genre);
          $manager->flush();
          return $this->redirectToRoute("genre_index");
      }
      return $this->renderForm("genre/add.html.twig",
      [
          'form' => $form
      ]);
   }

   #[Route('/edit/{id}', name: 'genre_edit')]
   public function genreEdit(Request $request, $id) {
     $genre = $this->getDoctrine()->getRepository(Genre::class)->find($id);
     $form = $this->createForm(GenreType::class,$genre);
     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($genre);
         $manager->flush();
         return $this->redirectToRoute("genre_index");
     }
     return $this->renderForm("genre/edit.html.twig",
     [
         'form' => $form
     ]);   
   }
}
