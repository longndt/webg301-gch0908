<?php

namespace App\Controller;

use App\Entity\Laptop;
use App\Form\LaptopType;
use App\Repository\LaptopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/laptop')]
class LaptopController extends AbstractController
{
    #[Route('/', name: 'laptop_index', methods: ['GET'])]
    public function index(LaptopRepository $laptopRepository): Response
    {
        return $this->render('laptop/index.html.twig', [
            'laptops' => $laptopRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'laptop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $laptop = new Laptop();
        $form = $this->createForm(LaptopType::class, $laptop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($laptop);
            $entityManager->flush();

            return $this->redirectToRoute('laptop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('laptop/new.html.twig', [
            'laptop' => $laptop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'laptop_show', methods: ['GET'])]
    public function show(Laptop $laptop): Response
    {
        return $this->render('laptop/show.html.twig', [
            'laptop' => $laptop,
        ]);
    }

    #[Route('/{id}/edit', name: 'laptop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Laptop $laptop, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LaptopType::class, $laptop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('laptop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('laptop/edit.html.twig', [
            'laptop' => $laptop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'laptop_delete', methods: ['POST'])]
    public function delete(Request $request, Laptop $laptop, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$laptop->getId(), $request->request->get('_token'))) {
            $entityManager->remove($laptop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('laptop_index', [], Response::HTTP_SEE_OTHER);
    }
}
