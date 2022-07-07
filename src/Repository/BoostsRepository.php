<?php

namespace App\Repository;

use App\Entity\Boosts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Boosts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boosts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boosts[]    findAll()
 * @method Boosts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boosts::class);
    }

    // /**
    //  * @return Boosts[] Returns an array of Boosts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Boosts
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
