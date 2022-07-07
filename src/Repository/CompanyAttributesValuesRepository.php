<?php

namespace App\Repository;

use App\Entity\CompanyAttributesValues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyAttributesValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyAttributesValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyAttributesValues[]    findAll()
 * @method CompanyAttributesValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyAttributesValuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyAttributesValues::class);
    }

    // /**
    //  * @return CompanyAttributesValues[] Returns an array of CompanyAttributesValues objects
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
    public function findOneBySomeField($value): ?CompanyAttributesValues
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
