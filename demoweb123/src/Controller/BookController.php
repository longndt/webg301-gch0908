<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        if ($book == null) {
            $this->addFlash("Error","Book not found !");
            //redirect về trang book index
            return $this->redirectToRoute('book_index');
        }
        //b2: render ra view gửi kèm dữ liệu ở trên
        return $this->render("book/detail.html.twig",
        [
            'book' => $book
        ]);
    }

    #[Route('/delete/{id}', name: 'book_delete')]
    public function deleteBook ($id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if ($book == null) {
            $this->addFlash("Error","Book not found !");
        } else {
            //gọi đến entity manager để xóa object
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($book);
            $manager->flush();
            //gửi message từ controller đến view sau khi xóa thành công
            $this->addFlash("Success","Delete book succeed !");
        }
        //redirect về trang book index
        return $this->redirectToRoute('book_index');
    }

    #[Route('/asc', name: 'sort_title_asc')]
    public function sortAsc (BookRepository $repository) {
        $books = $repository->sortTitleAscending();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

    #[Route('/desc', name: 'sort_title_desc')]
    public function sortDesc (BookRepository $repository) {
        $books = $repository->sortTitleDescending();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

    #[Route('/add', name: 'book_add')]
    public function addBook (Request $request) {
        $book = new Book;
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('book_index');
        }
        return $this->renderForm('book/add.html.twig',
        [
            'bookForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'book_edit')]
    public function editBook (Request $request, $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('book_index');
        }
        return $this->renderForm('book/edit.html.twig',
        [
            'bookForm' => $form
        ]);
    }
}
