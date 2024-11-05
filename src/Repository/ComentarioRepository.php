<?php

namespace App\Repository;

use App\Entity\Comentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentario::class);
    }

    // Aquí puedes añadir métodos personalizados para acceder a los comentarios
}
