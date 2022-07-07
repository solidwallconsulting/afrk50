<?php

namespace App\Repository;

use App\Entity\PromotionInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PromotionInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromotionInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromotionInvoice[]    findAll()
 * @method PromotionInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromotionInvoice::class);
    }

    // /**
    //  * @return PromotionInvoice[] Returns an array of PromotionInvoice objects
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
    public function findOneBySomeField($value): ?PromotionInvoice
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
