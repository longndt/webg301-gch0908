<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
   #[Route('/', name: 'homepage')]
   public function homepage() {
       $text = "Happy new year";
       $number = 2022;
       $country = array("Vietnam","Thailand","Singapore","Malaysia");
       return $this->render("demo/index.html.twig", 
                            [
                                'text' => $text,
                                'number' => $number,
                                'country' => $country
                            ]);
   }
}
