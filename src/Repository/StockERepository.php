<?php

namespace App\Repository;

use App\Entity\StockE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StockE|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockE|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockE[]    findAll()
 * @method StockE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockE::class);
    }


public function findAllstock(): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = 'SELECT stock_e.id,produit.produit_code,prdouits_id,produit.description,qty FROM stock_e INNER JOIN produit on stock_e.prdouits_id=produit.id';
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();
}

    // /**
    //  * @return StockE[] Returns an array of StockE objects
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
    public function findOneBySomeField($value): ?StockE
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
