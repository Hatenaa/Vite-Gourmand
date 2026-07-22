<?php

namespace App\EventListener;

use App\Document\OrderStat;
use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postUpdate, entity: Menu::class)]
#[AsEntityListener(event: Events::postRemove, entity: Menu::class)]
class MenuSyncListener
{
    public function __construct(private DocumentManager $documentManager)
    {

    }

    public function postUpdate(Menu $menu, PostUpdateEventArgs $event): void
    {
        $changeSet = $event->getObjectManager()->getUnitOfWork()->getEntityChangeSet($menu);

        if (!array_key_exists('title', $changeSet)){
            return;
        }

        [$oldTitle, $newTitle] = $changeSet['title'];

        $this->documentManager
            ->createQueryBuilder(OrderStat::class)
            ->updateMany()
            ->field('menuTitle')->equals($oldTitle)
            ->field('menuTitle')->set($newTitle)
            ->getQuery()
            ->execute();
    }

    public function postRemove(Menu $menu, PostRemoveEventArgs $event): void
    {
        $this->documentManager
            ->createQueryBuilder(OrderStat::class)
            ->remove()
            ->field('menuTitle')->equals($menu->getTitle())
            ->getQuery()
            ->execute();
    }
}