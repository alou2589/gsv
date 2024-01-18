<?php

namespace App\Repository;

use App\Entity\Emargement;
use DoctrineExtensions\Query\Mysql\IfElse;
use DoctrineExtensions\Query\Postgresql;
use DoctrineExtensions\Query\Mysql;
use App\Entity\BilanVolontaireSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @extends ServiceEntityRepository<Emargement>
 *
 * @method Emargement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emargement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emargement[]    findAll()
 * @method Emargement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmargementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emargement::class);
    }
    
    public function findAllSearch(BilanVolontaireSearch $bilanSearch){
        $query=$this->createQueryBuilder('e')
        ->leftJoin('e.affectation','a')
        ->select("
                SUM(CASE WHEN IDENTITY(e.etat_tp)=(SELECT et.id FROM App\Entity\EtatTempsPresence et WHERE et.nom_etat_tp='Présent') THEN 1 ELSE 0 END ) AS total_presence,
                SUM(CASE WHEN IDENTITY(e.etat_tp)=(SELECT etp.id FROM App\Entity\EtatTempsPresence etp WHERE etp.nom_etat_tp='Absent') THEN 1 ELSE 0 END ) AS total_absence")
        ->groupBy('e.affectation')
        ->getQuery()
        ->getResult();
        return $query;
    }
    public function listeAbsence($date_debut,$date_fin)
    {
        $query=$this->createQueryBuilder('e')
        ->where("
            e.etat_tp=(SELECT et.id FROM App\Entity\EtatTempsPresence et WHERE et.nom_etat_tp='Absent')
        ")
        ->andWhere("
            MONTH(e.heure) BETWEEN MONTH(:date_debut) AND MONTH(:date_fin)
        ")
        ->setParameter('date_debut',$date_debut)
        ->setParameter('date_fin',$date_fin)
        ->getQuery()
        ->getResult();
        return $query;
    }
//    /**
//     * @return Emargement[] Returns an array of Emargement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Emargement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
