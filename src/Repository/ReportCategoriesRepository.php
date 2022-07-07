<?php

namespace App\Repository;

use App\Entity\ReportCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportCategories[]    findAll()
 * @method ReportCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportCategories::class);
    }

    // /**
    //  * @return ReportCategories[] Returns an array of ReportCategories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReportCategories
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
