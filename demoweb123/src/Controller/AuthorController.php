<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/author')]
class AuthorController extends AbstractController
{
    #[Route('', name: 'author_index')]
    public function ViewAllAuthor() {
        //b1: lấy dữ liệu từ db
        //SQL: SELECT * FROM author
        $author = $this->getDoctrine()->getRepository(Author::class)->findAll();
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
        } else {
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
}
