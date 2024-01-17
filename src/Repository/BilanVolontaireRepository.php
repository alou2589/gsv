<?php

namespace App\Repository;

use App\Entity\BilanSearch;
use App\Entity\BilanVolontaire;
use App\Entity\BilanVolontaireSearch;
use App\Entity\EmargementSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<BilanVolontaire>
 *
 * @method BilanVolontaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilanVolontaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilanVolontaire[]    findAll()
 * @method BilanVolontaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanVolontaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilanVolontaire::class);
    }  


//    /**
//     * @return BilanVolontaire[] Returns an array of BilanVolontaire objects
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

//    public function findOneBySomeField($value): ?BilanVolontaire
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
