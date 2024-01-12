<?php

namespace App\Repository;

use App\Entity\BilanSearch;
use App\Entity\BilanVolontaire;
use App\Entity\EmargementSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<BilanVolontaire>
 *
 * @method BilanVolontaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilanVolontaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilanVolontaire[]    findAll()
 * @method BilanVolontaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanVolontaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilanVolontaire::class);
    }  
    public function findAllSearch(BilanSearch $bilanSearch){
            $query=$this->createQueryBuilder('b')
            ->select('
                    DISTINCT(b.affectation) AS info_volontaire,
                    100*(SUM(b.nbjour_presence)/SUM(b.nb_jours_ouvrables)) AS taux_presence,
                    100*(SUM(b.nbjour_absence)/SUM(b.nb_jours_ouvrables)) AS taux_absence,
                    SUM(b.nb_jours_ouvrables) AS total
            ')
            ->where("CONCAT(b.mois,'/',b.annee) BETWEEN CONCAT(MONTH(:m1),'/',YEAR(:a1)) AND CONCAT(MONTH(:m2),'/',YEAR(:a2))")
            ->setParameter('m1',$bilanSearch->getMinDate())
            ->setParameter('a1',$bilanSearch->getMinDate())
            ->setParameter('m2',$bilanSearch->getMaxDate())
            ->setParameter('a2',$bilanSearch->getMaxDate())
            ->groupBy('b.affectation')
            ->getQuery()
            ->getResult();
        return $query;
    }


//    /**
//     * @return BilanVolontaire[] Returns an array of BilanVolontaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BilanVolontaire
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
