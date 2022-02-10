<?php

namespace App\Repository;

use App\Entity\Motorbike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Motorbike|null find($id, $lockMode = null, $lockVersion = null)
 * @method Motorbike|null findOneBy(array $criteria, array $orderBy = null)
 * @method Motorbike[]    findAll()
 * @method Motorbike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotorbikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motorbike::class);
    }

    // /**
    //  * @return Motorbike[] Returns an array of Motorbike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Motorbike
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
