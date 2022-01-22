<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<5; $i++) {
            $employee = new Employee;
            $employee->setName("Employee $i");
            $employee->setAddress("Ha Noi");
            $employee->setDob(\DateTime::createFromFormat('Y-m-d', '2005-07-02'));
            $employee->setSalary(1200.68);
            $employee->setImage("https://www.achievers.com/blog/wp-content/uploads/2020/05/05-27-20.jpg");
            $manager->persist($employee);
        }
        $manager->flush();
    }
}
