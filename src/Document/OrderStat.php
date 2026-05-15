<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: 'order_stats', repositoryClass: \App\Repository\OrderStatRepository::class)]
class OrderStat
{
    #[ODM\Id]
    private string $id;

    #[ODM\Field(type: 'string')]
    private string $menuTitle;

    #[ODM\Field(type: 'int')]
    private int $orderCount;

    #[ODM\Field(type: 'float')]
    private float $totalRevenue;

    #[ODM\Field(type: 'date_immutable')]
    private \DateTimeImmutable $month;

    public function getId(): string
    {
        return $this->id;
    }

    public function getMenuTitle(): string
    {
        return $this->menuTitle;
    }
    
    public function setMenuTitle(string $menuTitle): static
    {
        $this->menuTitle = $menuTitle;
        return $this;
    }

    public function getOrderCount(): int
    {
        return $this->orderCount;
    }

    public function setOrderCount(int $orderCount): static
    {
        $this->orderCount = $orderCount;
        return $this;
    }

    public function getTotalRevenue(): float
    {
        return $this->totalRevenue;
    }

    public function setTotalRevenue(float $totalRevenue): static
    {
        $this->totalRevenue = $totalRevenue;
        return $this;
    }

    public function getMonth(): \DateTimeImmutable
    {
        return $this->month;
    }

    public function setMonth(\DateTimeImmutable $month): static
    {
        $this->month = $month;
        return $this;
    }
}