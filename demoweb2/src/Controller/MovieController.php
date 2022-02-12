<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/movie')]
class MovieController extends AbstractController
{
   #[Route('', name: 'movie_index')]
   public function movieIndex() {
       $movie = $this->getDoctrine()->getRepository(Movie::class)->findAll();
       return $this->render("movie/index.html.twig",
       [
           'movies' => $movie
       ]);
   }

   #[Route('/detail/{id}', name: 'movie_detail')]
   public function movieDetail($id) {
       $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
       return $this->render("movie/detail.html.twig",
       [
           'movie' => $movie
       ]);
   }

   #[Route('/delete/{id}', name: 'movie_delete')]
   public function movieDelete($id) {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($movie);
        $manager->flush();
        return $this->redirectToRoute("movie_index");
   }

   #[Route('/add', name: 'movie_add')]
   public function movieAdd(Request $request) {
      $movie = new Movie;  
      $form = $this->createForm(MovieType::class,$movie);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($movie);
          $manager->flush();
          return $this->redirectToRoute("movie_index");
      }
      return $this->renderForm("movie/add.html.twig",
      [
          'form' => $form
      ]);
   }

   #[Route('/edit/{id}', name: 'movie_edit')]
   public function movieEdit(Request $request, $id) {
     $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
     $form = $this->createForm(MovieType::class,$movie);
     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($movie);
         $manager->flush();
         return $this->redirectToRoute("movie_index");
     }
     return $this->renderForm("movie/edit.html.twig",
     [
         'form' => $form
     ]);   
   }
}
