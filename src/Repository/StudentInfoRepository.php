<?php

namespace App\Repository;

use App\Entity\StudentInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudentInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentInfo[]    findAll()
 * @method StudentInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentInfo::class);
    }

    // /**
    //  * @return StudentInfo[] Returns an array of StudentInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StudentInfo
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
