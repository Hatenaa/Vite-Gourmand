<?php

namespace App\Repository;

use App\Document\OrderStat;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderStatRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderStat::class);
    }

    /**
     * @return OrderStat[]
     */

    public function findByFilters(array $menuTitles, ?\DateTimeImmutable $from, ?\DateTimeImmutable $to): array
    {
        if(empty($menuTitles)){
            return[];
        }

        $qb = $this->createQueryBuilder();
        $qb->field('menuTitle')->in($menuTitles);

        if($from !== null){
            $qb->field('month')->gte($from);
        }

        if($to !== null){
            $qb->field('month')->lte($to);
        }

        $qb->sort('month', 'ASC');

        return iterator_to_array($qb->getQuery()->execute(), false);
    }
}