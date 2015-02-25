<?php

namespace Perfico\CRMBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Perfico\CRMBundle\Entity\DealStateInterface;

class DealStateSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            Events::preRemove
        );
    }

    public function PreRemove(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if (!$entity instanceof DealStateInterface) {
            return;
        }

        if ($entity->getDeals()->count() && $entity->getHeir() instanceof DealStateInterface) {
            $qb = $eventArgs->getEntityManager()->createQueryBuilder();
            $query = $qb->update('CoreBundle:Deal', 'd')
                ->set('d.state', $entity->getHeir()->getId())
                ->where('d.state = :state')->setParameter('state', $entity)
                ->getQuery();

            $query->execute();
        }
    }
} 