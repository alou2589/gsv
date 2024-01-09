<?php

namespace App\Repository;

use App\Entity\Affectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Affectation>
 *
 * @method Affectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affectation[]    findAll()
 * @method Affectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affectation::class);
    }
    
    public function feuiileByService($id_sdc){
        return $this->createQueryBuilder('a')
            ->where('a.service_departemental= :sdc')
            ->setParameter('sdc',$id_sdc)
        ;
    }
    public function affectationBySdc($id_sdc){
        return $this->createQueryBuilder('a')
            ->where('a.service_departemental= :sdc')
            ->setParameter('sdc',$id_sdc)
        ;
    }
    
    
    public function regionVolontaires($region)
    {
        $query = $this->createQueryBuilder('a')
            ->where("a.service_departemental IN( SELECT sd.id FROM App\Entity\ServiceDepartemental sd WHERE sd.departement IN(SELECT d.id FROM App\Entity\Departements d WHERE d.region IN(SELECT r.id FROM App\Entity\Regions r WHERE r.id= :val) ))")
            ->setParameter('val', $region);
        
        return $query->getQuery()->getResult();
    }
    public function departementVolontaires($departement)
    {
        $query = $this->createQueryBuilder('a')
            ->where("a.service_departemental IN( SELECT sd.id FROM App\Entity\ServiceDepartemental sd WHERE sd.departement= :val)")
            ->setParameter('val', $departement);
        
        return $query->getQuery()->getResult();
    }
    public function srcVolontaires($src)
    {
        $query = $this->createQueryBuilder('a')
            ->where("a.service_departemental IN( SELECT sd.id FROM App\Entity\ServiceDepartemental sd WHERE sd.service_regional= :val)")
            ->setParameter('val', $src);
        
        return $query->getQuery()->getResult();
    }
    

//    /**
//     * @return Affectation[] Returns an array of Affectation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Affectation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
