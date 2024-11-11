<?php

namespace App\Repository;

use App\Entity\ActividadAcceso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActividadAcceso>
 *
 * @method ActividadAcceso|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActividadAcceso|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActividadAcceso[]    findAll()
 * @method ActividadAcceso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActividadAccesoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActividadAcceso::class);
    }

    // Agrega aquí métodos personalizados de consulta si es necesario
}
