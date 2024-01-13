<?php

namespace App\Repository;

use App\Entity\Emargement;
use App\Entity\BilanSearch;
use App\Entity\EmargementSearch;
use DoctrineExtensions\Query\Mysql;
use DoctrineExtensions\Query\Mysql\Year;
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
    public function findByMonth($affectation,$month, $year, $nomTp)
    {
        $query = $this->createQueryBuilder('e')
            ->where("MONTH(e.heure)= :month")
            ->andwhere("YEAR(e.heure)= :year")
            ->andwhere("e.affectation= :affectation")
            ->andwhere("e.etat_tp= (SELECT etp.id FROM App\Entity\EtatTempsPresence etp WHERE etp.nom_etat_tp=:nomTp)")
            ->setParameter('month', $month)
            ->setParameter('year', $year)
            ->setParameter('affectation', $affectation)
            ->setParameter('nomTp', $nomTp)
        ;
        return $query->getQuery()->getResult();
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
