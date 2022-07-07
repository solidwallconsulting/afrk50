<?php

namespace App\Repository;

use App\Entity\CompanyWorkingDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyWorkingDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyWorkingDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyWorkingDay[]    findAll()
 * @method CompanyWorkingDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyWorkingDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyWorkingDay::class);
    }

    // /**
    //  * @return CompanyWorkingDay[] Returns an array of CompanyWorkingDay objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompanyWorkingDay
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
