<?php

namespace App\Controller;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee')]
class EmployeeController extends AbstractController
{
    #[Route('/', name: 'employee_list')]
    public function employeeList() {
        $employee = $this->getDoctrine()->getRepository(Employee::class)->findAll();
        return $this->render("employee/index.html.twig",
                            [
                                'employee' => $employee
                            ]);
    }

    #[Route('/{id}', name: 'employee_detail')]
    public function employeeDetail($id) {
        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($id);
        return $this->render("employee/detail.html.twig",
                            [
                                'employee' => $employee
                            ]);
    }
}
