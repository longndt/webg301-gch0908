<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
   //tạo controller để render ra view chứa form nhập liệu 
   //và lấy dữ liệu từ form sau đó đẩy dữ liệu ra 1 view khác 
   //Note: tạo form ngay trong controller
   #[Route('/new', name: 'new_note')]
   public function newNote(Request $request) {
      //tạo object cho entity Note
      $note = new Note;
      //tạo form bằng FormBuilder
      $form = $this->createFormBuilder($note)
                   ->add('title', TextType::class)
                   ->add('content', TextType::class)
                   ->add('date', DateType::class,
                        [
                            'widget' => 'single_text'
                        ]      
                        )
                   ->add('Create', SubmitType::class)
                   ->getForm();
      //handle request 
      $form->handleRequest($request);
      //xử lý dữ liệu nhập vào từ form
      //check xem form đã được submit chưa và check tính hợp lệ của form
      if ($form->isSubmitted() && $form->isValid()) {
          //lấy dữ liệu từ form và lưu ra các biến tương ứng
          $data = $form->getData();
          $title = $data->getTitle();
          $content = $data->getContent();
          $date = $data->getDate();
          //đẩy giá trị của các biến này sang 1 view khác để show kết quả
          return $this->render('note/result.html.twig',
                              [
                                  'title' => $title,
                                  'content' => $content,
                                  'date' => $date
                              ]); 
      }

      //render ra view chứa form
      return $this->render('note/new.html.twig',
                            [
                                'noteForm' => $form->createView()
                            ]);
   }



   //tạo controller để render ra view chứa form nhập liệu
   //đẩy dữ liệu nhập từ form vào DB sau đấy chuyển đến view khác
   //chứa toàn bộ record trong bảng Note
   //Note: không tạo form trong controller 
   #[Route('/add', name: 'add_note')]
   public function addNote(Request $request) {
        $note = new Note;
        $form = $this->createForm(NoteType::class,$note);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //lưu dữ liệu từ form vào DB
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($note);
            $manager->flush();
            //redirect đến 1 route khác
            return $this->redirectToRoute("list_note");
        }

        return $this->renderForm('note/new.html.twig',     
                                [
                                    'noteForm' => $form    
                                ]);
   }

   #[Route('/list', name: 'list_note')]
   public function listNote() {
       $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();
       return $this->render('note/list.html.twig',
                            [
                                'notes' => $notes
                            ]);
   }
}
