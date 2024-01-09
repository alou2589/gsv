<?php

namespace App\Repository;

use App\Entity\ServiceDepartemental;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceDepartemental>
 *
 * @method ServiceDepartemental|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceDepartemental|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceDepartemental[]    findAll()
 * @method ServiceDepartemental[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceDepartementalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceDepartemental::class);
    }

//    /**
//     * @return ServiceDepartemental[] Returns an array of ServiceDepartemental objects
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

//    public function findOneBySomeField($value): ?ServiceDepartemental
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
