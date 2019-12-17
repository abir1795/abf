<?php

namespace App\Repository;

use App\Entity\BonlivrsnLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BonlivrsnLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method BonlivrsnLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method BonlivrsnLine[]    findAll()
 * @method BonlivrsnLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonlivrsnLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BonlivrsnLine::class);
    }

    // /**
    //  * @return BonlivrsnLine[] Returns an array of BonlivrsnLine objects
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
    public function findOneBySomeField($value): ?BonlivrsnLine
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
