<?php

namespace App\Repository;

use App\Entity\BulletinVolontaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BulletinVolontaire>
 *
 * @method BulletinVolontaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method BulletinVolontaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method BulletinVolontaire[]    findAll()
 * @method BulletinVolontaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BulletinVolontaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BulletinVolontaire::class);
    }

//    /**
//     * @return BulletinVolontaire[] Returns an array of BulletinVolontaire objects
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

//    public function findOneBySomeField($value): ?BulletinVolontaire
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
