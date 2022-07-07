<?php

namespace App\Repository;

use App\Entity\CompanyCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyCategories[]    findAll()
 * @method CompanyCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyCategories::class);
    }

    // /**
    //  * @return CompanyCategories[] Returns an array of CompanyCategories objects
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
    public function findOneBySomeField($value): ?CompanyCategories
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
