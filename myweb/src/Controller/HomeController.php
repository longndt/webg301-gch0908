<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $university = "Greenwich Vietnam";
        $semester = "Spring 2022";
        $city = array("Hanoi", "HCM City", "Da nang");
        return $this->render('home/index.html.twig',
            [
                'uni' => $university,
                'sem' => $semester,
                'city' => $city
            ]);
    }
}
