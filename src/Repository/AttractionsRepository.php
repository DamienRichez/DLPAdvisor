<?php

namespace App\Repository;

use App\Entity\Attractions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Attractions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attractions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attractions[]    findAll()
 * @method Attractions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttractionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attractions::class);
    }

    // /**
    //  * @return Attractions[] Returns an array of Attractions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Attractions
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
