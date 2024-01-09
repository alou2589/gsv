<?php

namespace App\Repository;

use App\Entity\ServiceRegional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceRegional>
 *
 * @method ServiceRegional|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceRegional|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceRegional[]    findAll()
 * @method ServiceRegional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRegionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceRegional::class);
    }

//    /**
//     * @return ServiceRegional[] Returns an array of ServiceRegional objects
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

//    public function findOneBySomeField($value): ?ServiceRegional
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
