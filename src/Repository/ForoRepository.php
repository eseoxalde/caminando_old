<?php

namespace App\Repository;

use App\Entity\Foro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ForoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Foro::class);
    }

    public function findLatest(): ?Foro
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
}
