<?php

namespace App\Repository;

use App\Entity\FeuillePresence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FeuillePresence>
 *
 * @method FeuillePresence|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeuillePresence|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeuillePresence[]    findAll()
 * @method FeuillePresence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeuillePresenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeuillePresence::class);
    }
    
    public function findByFeuille($nomSdc){
        return $this->createQueryBuilder('f')
            ->where('f.service_departemental = (SELECT s.id FROM App\Entity\ServiceDepartemental s WHERE s.nom_sdc= :nomSdc)')
            ->setParameter('nomSdc',$nomSdc)
        ;
    }
    public function findByMonth($date_feuille){
        return $this->createQueryBuilder('f')
            ->where('MONTH(f.date_feuille)= :date_feuille')
            ->setParameter('date_feuille', $date_feuille)
            ->getQuery()
            ->getResult()
            ;
    } 

//    /**
//     * @return FeuillePresence[] Returns an array of FeuillePresence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FeuillePresence
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
