<?php

namespace App\Repository;

use App\Entity\ListingReports;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingReports|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingReports|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingReports[]    findAll()
 * @method ListingReports[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingReportsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingReports::class);
    }

    // /**
    //  * @return ListingReports[] Returns an array of ListingReports objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListingReports
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
