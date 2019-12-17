<?php

namespace App\Repository;

use App\Entity\CommandeHead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommandeHead|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeHead|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeHead[]    findAll()
 * @method CommandeHead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeHeadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeHead::class);
    }



    public function getcommandebyDate($id){

        $conn=$this->getEntityManager()->getConnection();
        $sql='select id,date_create,status,commande_total from commande_head where user_id=:id order by date_create desc';
        $stmt=$conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return $stmt->fetchAll();
    }


    public function countCommandeHead(){

        $conn=$this->getEntityManager()->getConnection();
        $sql='SELECT count(*)as "count" FROM `commande_head` ';
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findCommandeWithUserIfo(): array{
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'select commande_head.id,commande_head.date_create,commande_head.commande_total,commande_head.user_id,user.nom,user.prenom,status from commande_head inner join user on commande_head.user_id=user.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function caCommande(){
        $conn = $this->getEntityManager()->getConnection();
        $sql="SELECT sum(commande_total) as 'CaCommande' from commande_head";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function CountCommandeTraitee(){
        $conn=$this->getEntityManager()->getConnection();
        $sql="SELECT count(commande_total)as 'traitee' from commande_head where `status`='Traitée'";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function CountNonTraite(){
        $conn=$this->getEntityManager()->getConnection();
        $sql="SELECT count(commande_total)as 'notraitee' from commande_head where `status`='Non Traite'";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getRecentCommande():array {
        $conn=$this->getEntityManager()->getConnection();
        $sql="
        SELECT produit.image_url,commande.product_name,user.nom,user.prenom,commande_head.date_create,commande_head.status, 
        commande_head.id FROM user inner join commande_head on user.id=commande_head.user_id
         inner join commande on commande_head.id=commande.commande_head_id 
        inner join produit on commande.product_id=produit.id order by commande_head.date_create DESC
        ";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    // /**
    //  * @return CommandeHead[] Returns an array of CommandeHead objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandeHead
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
