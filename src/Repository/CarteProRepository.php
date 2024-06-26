<?php

namespace App\Repository;

use App\Entity\CartePro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartePro>
 *
 * @method CartePro|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartePro|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartePro[]    findAll()
 * @method CartePro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteProRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartePro::class);
    }

//    /**
//     * @return CartePro[] Returns an array of CartePro objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CartePro
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
