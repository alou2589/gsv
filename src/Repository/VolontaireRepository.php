<?php

namespace App\Repository;

use App\Entity\Volontaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Volontaire>
 *
 * @method Volontaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Volontaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Volontaire[]    findAll()
 * @method Volontaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VolontaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Volontaire::class);
    }

//    /**
//     * @return Volontaire[] Returns an array of Volontaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Volontaire
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
