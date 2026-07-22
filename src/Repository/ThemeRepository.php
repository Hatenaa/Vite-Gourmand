<?php

namespace App\Repository;

use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Theme>
 */
class ThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }
    
    public function findThemesWithMenus(): array
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.menus', 'm')
            ->andWhere('m.isActive = :isActive')
            ->setParameter('isActive', true)
            ->distinct()
            ->getQuery()
            ->getResult();
    }
    
}
