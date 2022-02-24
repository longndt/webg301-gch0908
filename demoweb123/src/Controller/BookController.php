<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPUnit\Framework\throwException;

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

    /**
     * @IsGranted("ROLE_MANAGER")
     */
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

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/add', name: 'book_add')]
    public function addBook (Request $request) {
        $book = new Book;
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //code upload & xử lý tên ảnh
            //B1: lấy tên ảnh từ file upload
            $image = $book->getImage();
            //B2: đặt tên mới cho ảnh
            //=> đảm bảo tên file ảnh là duy nhất
            $imgName = uniqid(); //unique id
            //B3: lấy phần đuôi của ảnh (image extension)
            $imgExtension = $image->guessExtension();
            //Note: cần phải cấu hình lại getter & setter trong Entity
            //B4: merge thành 1 tên file ảnh mới 
            $imageName = $imgName . '.' . $imgExtension;
            //B5: di chuyển ảnh đến thư mục chỉ định trong project
            try {
                $image->move(
                    $this->getParameter('book_cover'), $imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }
            //B6: set tên ảnh mới để lưu vào DB
            $book->setImage($imageName);
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

    /**
     * @IsGranted("ROLE_MANAGER")
     */
    #[Route('/edit/{id}', name: 'book_edit')]
    public function editBook (Request $request, $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //code upload & xử lý tên ảnh
            //B1: lấy dữ liệu ảnh từ form edit
            $file = $form['image']->getData();      
            //B2: check xem dữ liệu ảnh có null không
            //=> người dùng có upload ảnh mới để thay thế hay không
            if ($file != null) {
                //B3: lấy tên ảnh từ file upload
                $image = $book->getImage();
                //B4: đặt tên mới cho ảnh
                //=> đảm bảo tên file ảnh là duy nhất
                $imgName = uniqid(); //unique id
                //B5: lấy phần đuôi của ảnh (image extension)
                $imgExtension = $image->guessExtension();
                //Note: cần phải cấu hình lại getter & setter trong Entity
                //B6: merge thành 1 tên file ảnh mới
                $imageName = $imgName . '.' . $imgExtension;
                //B7: di chuyển ảnh đến thư mục chỉ định trong project
                try {
                    $image->move(
                        $this->getParameter('book_cover'),
                        $imageName
                    );
                } catch (FileException $e) {
                    throwException($e);
                }
                //B8: set tên ảnh mới để lưu vào DB
                $book->setImage($imageName);
            }
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
