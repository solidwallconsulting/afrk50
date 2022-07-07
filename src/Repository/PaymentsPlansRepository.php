<?php

namespace App\Repository;

use App\Entity\PaymentsPlans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentsPlans|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentsPlans|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentsPlans[]    findAll()
 * @method PaymentsPlans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentsPlansRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentsPlans::class);
    }

    // /**
    //  * @return PaymentsPlans[] Returns an array of PaymentsPlans objects
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
    public function findOneBySomeField($value): ?PaymentsPlans
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
