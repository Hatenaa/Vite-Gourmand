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

    public function findFilteredMenus(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('m')
        ->leftJoin('m.images', 'i')
        ->addSelect('i')
        ->leftJoin('m.theme', 't')
        ->addSelect('t')
        ->leftJoin('m.regime', 'r')
        ->addSelect('r')
        ->andWhere('m.isActive = :isActive')
        ->setParameter('isActive', true)
        ->orderBy('m.id', 'DESC')
        ->addOrderBy('i.position', 'ASC');

        if (isset($filters['minPrice']) && $filters['minPrice'] !== ''){
            $qb->andWhere('m.basePrice >= :minPrice')
            ->setParameter('minPrice', $filters['minPrice']);
        }

        if (isset($filters['maxPrice']) && $filters['maxPrice'] !== ''){
            $qb->andWhere('m.basePrice <= :maxPrice')
            ->setParameter('maxPrice', $filters['maxPrice']);
        }

        if (isset($filters['theme']) && $filters['theme'] !== ''){
            $qb->andWhere('t.id = :theme')
            ->setParameter('theme', $filters['theme']);
        }

        if (isset($filters['regime']) && $filters['regime'] !== ''){
            $qb->andWhere('r.id = :regime')
            ->setParameter('regime', $filters['regime']);
        }

        if (isset($filters['minPeople']) && $filters['minPeople'] !== ''){
            $qb->andWhere('m.minPeople >= :minPeople')
            ->setParameter('minPeople', $filters['minPeople']);
        }

        return $qb->getQuery()->getResult();
    }
}
