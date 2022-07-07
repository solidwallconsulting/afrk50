<?php

namespace App\Repository;

use App\Entity\CompanyAttributes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyAttributes|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyAttributes|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyAttributes[]    findAll()
 * @method CompanyAttributes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyAttributesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyAttributes::class);
    }

    // /**
    //  * @return CompanyAttributes[] Returns an array of CompanyAttributes objects
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
    public function findOneBySomeField($value): ?CompanyAttributes
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
