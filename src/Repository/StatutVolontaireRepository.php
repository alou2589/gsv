<?php

namespace App\Repository;

use App\Entity\StatutVolontaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatutVolontaire>
 *
 * @method StatutVolontaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutVolontaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutVolontaire[]    findAll()
 * @method StatutVolontaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutVolontaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutVolontaire::class);
    }

//    /**
//     * @return StatutVolontaire[] Returns an array of StatutVolontaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StatutVolontaire
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
