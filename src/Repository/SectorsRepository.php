<?php

namespace App\Repository;

use App\Entity\Sectors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sectors|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sectors|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sectors[]    findAll()
 * @method Sectors[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sectors::class);
    }

    // /**
    //  * @return Sectors[] Returns an array of Sectors objects
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
    public function findOneBySomeField($value): ?Sectors
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
