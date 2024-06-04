<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menu>
 *
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function findVisibleMenus(): array
    {
        return $this->createQueryBuilder('m')
        ->leftJoin('m.children', 'c')
        ->addSelect('c')
        ->where('m.visible = :visible')
        ->andWhere('c.visible = :visible OR c.id IS NULL')
        ->setParameter('visible', true)
        ->orderBy('m.parent, m.posicion', 'ASC')
        ->addOrderBy('c.posicion', 'ASC')
        ->getQuery()
        ->getResult();
    }

}