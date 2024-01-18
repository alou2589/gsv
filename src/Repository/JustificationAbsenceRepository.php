<?php

namespace App\Repository;

use App\Entity\JustificationAbsence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JustificationAbsence>
 *
 * @method JustificationAbsence|null find($id, $lockMode = null, $lockVersion = null)
 * @method JustificationAbsence|null findOneBy(array $criteria, array $orderBy = null)
 * @method JustificationAbsence[]    findAll()
 * @method JustificationAbsence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JustificationAbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JustificationAbsence::class);
    }
    

//    /**
//     * @return JustificationAbsence[] Returns an array of JustificationAbsence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JustificationAbsence
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
