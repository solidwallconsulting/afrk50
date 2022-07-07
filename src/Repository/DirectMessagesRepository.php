<?php

namespace App\Repository;

use App\Entity\DirectMessages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DirectMessages|null find($id, $lockMode = null, $lockVersion = null)
 * @method DirectMessages|null findOneBy(array $criteria, array $orderBy = null)
 * @method DirectMessages[]    findAll()
 * @method DirectMessages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectMessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DirectMessages::class);
    }

    // /**
    //  * @return DirectMessages[] Returns an array of DirectMessages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DirectMessages
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
