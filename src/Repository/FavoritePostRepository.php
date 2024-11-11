<?php
namespace App\Repository;

use App\Entity\FavoritePost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FavoritePostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoritePost::class);
    }

    // Aquí puedes agregar tus consultas personalizadas
}
