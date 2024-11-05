<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findImportantPosts(?int $limit = null)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.isImportant = :important')
            ->setParameter('important', true)
            ->orderBy('p.createdAt', 'DESC');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findLatestPostsExcludingImportant(?int $limit = null)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.isImportant = :important')
            ->setParameter('important', false)
            ->orderBy('p.createdAt', 'DESC');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findWithCounts()
    {
        return $this->createQueryBuilder('p')
            ->select('p, COUNT(d) AS debateCount, COUNT(c) AS messageCount')
            ->leftJoin('p.debates', 'd') // Asegúrate de tener la relación debates en tu entidad Post
            ->leftJoin('p.comentarios', 'c')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }
}
