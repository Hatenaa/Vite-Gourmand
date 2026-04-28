<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menu>
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function findAllForGlobalView(): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.images', 'i')
            ->addSelect('i')
            ->andWhere('m.isActive = :isActive')
            ->setParameter('isActive', true)
            ->orderBy('m.id', 'DESC')
            ->addOrderBy('i.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
