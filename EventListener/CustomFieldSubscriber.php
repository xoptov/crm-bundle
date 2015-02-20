<?php

namespace Perfico\CRMBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Perfico\CoreBundle\Entity\CustomField;

class CustomFieldSubscriber implements EventSubscriber
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

        if (!$entity instanceof CustomField) {
            return;
        }

        $methods = get_class_methods('Perfico\CoreBundle\Entity\Client');

        if (in_array('setCustomField' . $entity->getNumber(), $methods)) {
            $qb = $eventArgs->getEntityManager()->createQueryBuilder();
            $query = $qb->update('CoreBundle:Client', 'c')
                ->set('c.customField' . $entity->getNumber(), 'NULL')
                ->where('c.account = :account')
                ->setParameter('account', $entity->getAccount())
                ->getQuery();

            $query->execute();
        }
    }
} 