<?php

namespace App\Repository;

use App\Entity\Sitio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sitio>
 *
 * @method Sitio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sitio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sitio[]    findAll()
 * @method Sitio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sitio::class);
    }

    //    /**
    //     * @return Sitio[] Returns an array of Sitio objects
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

    //    public function findOneBySomeField($value): ?Sitio
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
