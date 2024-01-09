<?php

namespace App\Repository;

use App\Entity\EtatTempsPresence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtatTempsPresence>
 *
 * @method EtatTempsPresence|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatTempsPresence|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatTempsPresence[]    findAll()
 * @method EtatTempsPresence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatTempsPresenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatTempsPresence::class);
    }

//    /**
//     * @return EtatTempsPresence[] Returns an array of EtatTempsPresence objects
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

//    public function findOneBySomeField($value): ?EtatTempsPresence
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
