<?php

namespace App\Repository;

use App\Entity\ListingAttributes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingAttributes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingAttributes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingAttributes[]    findAll()
 * @method ListingAttributes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingAttributesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingAttributes::class);
    }

    // /**
    //  * @return ListingAttributes[] Returns an array of ListingAttributes objects
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
    public function findOneBySomeField($value): ?ListingAttributes
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
