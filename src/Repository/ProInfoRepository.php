<?php

namespace App\Repository;

use App\Entity\ProInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProInfo[]    findAll()
 * @method ProInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProInfo::class);
    }

    // /**
    //  * @return ProInfo[] Returns an array of ProInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProInfo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
