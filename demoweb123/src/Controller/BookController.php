<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'book_index')]
    public function ViewAllBook() {
        //b1: lấy dữ liệu từ db
        //SQL: SELECT * FROM book
        $book = $this->getDoctrine()->getRepository(Book::class)->findAll();
        //b2: render ra view gửi kèm dữ liệu ở trên
        return $this->render("book/index.html.twig",
            [
                'books' => $book
            ]);

    }

    #[Route('/detail/{id}', name: 'book_detail')]
    public function ViewBookById ($id) {
        //b1: lấy dữ liệu từ db
        //SQL: SELECT * FROM book WHERE id = '$id'
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        //b2: render ra view gửi kèm dữ liệu ở trên
        return $this->render("book/index.html.twig",
        [
            'book' => $book
        ]);
    }
}
