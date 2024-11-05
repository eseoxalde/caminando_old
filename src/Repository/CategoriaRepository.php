<?php
namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 *
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function findWithPostAndCommentCount()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name, c.description, COUNT(p) AS postCount, COUNT(com) AS messageCount')
            ->leftJoin('c.posts', 'p') 
            ->leftJoin('p.comentarios', 'com') 
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    }

}
