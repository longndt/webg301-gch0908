<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

#[Route('/blog')]
class BlogController extends AbstractController
{
   //class variable (global variable)
   public $serializerInterface;
   public $registry;

   //constructor
   public function __construct(SerializerInterface $serializerInterface, ManagerRegistry $registry)
   {
      $this->serializerInterface = $serializerInterface;
      $this->registry = $registry;
   }

   //READ - SELECT * FROM Blog
   #[Route('/', methods: 'GET', name : 'view_all_blog')]
   public function blogIndex() {
      //lấy dữ liệu từ database và lưu vào array
      $blogs = $this->registry->getRepository(Blog::class)->findAll();
      //convert dữ liệu thành api (json)
      $json = $this->serializerInterface->serialize($blogs,"json");
      //trả về api
      return new Response($json,
                          Response::HTTP_OK, //status: 200,
                          [
                             'content-type' => 'application/json'
                          ]
      );
   }

   //READ - SELECT * FROM Blog WHERE id='$id'
   #[Route('/{id}', methods: 'GET', name : 'view_blog_by_id')]
   /**
    * @Route("/{id}", methods = {"GET"}, name = "view_blog_by_id")
    */
   public function blogDetail($id) {
       //lấy dữ liệu từ database và lưu vào object
       $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
       //check xem blog object có tồn tại không
       if ($blog == null) {
          $error = json_encode("Sorry, blog id is not found. Try again !");
          return new Response($error, Response::HTTP_NOT_FOUND //status: 404
          );
       }
       //convert dữ liệu thành api (xml)
       $xml = $this->serializerInterface->serialize($blog,"xml");
       //trả về api
       return new Response($xml,
       Response::HTTP_OK, //status: 200,
                  [
                     'content-type' => 'application/xml'
                  ]
      );
   }

   #[Route('/{id}', methods: 'DELETE', name: 'delete_blog')]
   public function blogDelete($id) {
      //lấy dữ liệu từ database và lưu vào object
      $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
      //check xem blog object có tồn tại không
      if ($blog == null) {
         $error = json_encode("Sorry, blog id is not found. Try again !");
         return new Response($error, Response::HTTP_NOT_FOUND); //code: 404
      }
      //thực hiện xóa object bằng manager
      $manager = $this->getDoctrine()->getManager();
      $manager->remove($blog);
      $manager->flush();
      return new Response(null, Response::HTTP_NO_CONTENT); //code: 204
   }

   #[Route('/add', methods: 'POST', name: 'add_blog')]
   public function blogAdd(Request $request) {
      //tạo 1 blog object mới
      $blog = new Blog;
      //decode dữ liệu gửi từ request của client
      $data = json_decode($request->getContent(),true);
      //set dữ liệu vào blog object đã tạo
      $blog->setTitle($data['title']);
      $blog->setAuthor($data['author']);
      $blog->setContent($data['content']);
      $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));
      //đẩy dữ liệu vào DB thông qua manager
      $manager = $this->getDoctrine()->getManager();
      $manager->persist($blog);
      $manager->flush();
      return new Response(null, Response::HTTP_CREATED); //code: 201
   }

   #[Route('/{id}', methods: 'PUT', name: 'edit_blog')]
   public function blogEdit(Request $request, $id) {
      $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
      if ($blog == null) {
         $error = json_encode("Sorry, blog id is not found. Try again !");
         return new Response($error, Response::HTTP_NOT_FOUND); //code: 404
      }
       //decode dữ liệu gửi từ request của client
       $data = json_decode($request->getContent(),true);
       //set dữ liệu vào blog object đã tạo
       $blog->setTitle($data['title']);
       $blog->setAuthor($data['author']);
       $blog->setContent($data['content']);
       $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));
       //đẩy dữ liệu vào DB thông qua manager
       $manager = $this->getDoctrine()->getManager();
       $manager->persist($blog);
       $manager->flush();
       return new Response(null, Response::HTTP_ACCEPTED); //code: 202
   }
}
