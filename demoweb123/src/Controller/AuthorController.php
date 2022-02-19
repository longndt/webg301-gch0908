<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/author')]
class AuthorController extends AbstractController
{
    #[Route('', name: 'author_index')]
    public function ViewAllAuthor(AuthorRepository $repository) {
        //b1: lấy dữ liệu từ db
        //SQL: SELECT * FROM author
        //$author = $this->getDoctrine()->getRepository(Author::class)->findAll();
        $author = $repository->viewAuthorList();
        //b2: render ra view gửi kèm dữ liệu ở trên
        return $this->render("author/index.html.twig",
            [
                'authors' => $author
            ]);
    }

    #[Route('/detail/{id}', name: 'author_detail')]
    public function ViewAuthorById ($id) {
        //b1: lấy dữ liệu từ db
        //SQL: SELECT * FROM author WHERE id = '$id'
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        if ($author == null) {
            $this->addFlash("Error","Author not found !");
            //redirect về trang author index
            return $this->redirectToRoute('author_index');
        }
        //b2: render ra view gửi kèm dữ liệu ở trên
        return $this->render("author/detail.html.twig",
        [
            'author' => $author
        ]);
    }

    #[Route('/delete/{id}', name: 'author_delete')]
    public function deleteAuthor ($id) {
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        if ($author == null) {
            $this->addFlash("Error","Author not found !");
        } 
        //check xem tác giả có tối thiểu 1 sách hay không trước khi xóa
        else if (count($author->getBooks()) > 0) {
            $this->addFlash("Error","Can not delete this author !");
        }
        else {
            //gọi đến entity manager để xóa object
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($author);
            $manager->flush();
            //gửi message từ controller đến view sau khi xóa thành công
            $this->addFlash("Success","Delete author succeed !");
        }
        //redirect về trang author index
        return $this->redirectToRoute('author_index');
    }

    #[Route('/add', name: 'author_add')]
    public function addAuthor (Request $request) {
        $author = new Author;
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($author);
            $manager->flush();
            return $this->redirectToRoute('author_index');
        }
        return $this->renderForm('author/add.html.twig',
        [
            'authorForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'author_edit')]
    public function editAuthor (Request $request, $id) {
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($author);
            $manager->flush();
            return $this->redirectToRoute('author_index');
        }
        return $this->renderForm(
            'author/edit.html.twig',
            [
            'authorForm' => $form
        ]
        );
    }
    #[Route('/search' , name: 'author_search')]
    public function searchAuthor (Request $request, AuthorRepository $repository) {
        $name = $request->get('word');
        $author = $repository->searchAuthor($name);
            return $this->render("author/index.html.twig",
            [
                'authors' => $author
            ]);
    }
}
