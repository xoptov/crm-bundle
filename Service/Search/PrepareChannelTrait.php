<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyChannelInterface;

trait PrepareChannelTrait
{
    protected function prepareChannelCondition(QueryBuilder $qb, PropertyChannelInterface $conditions, $alias)
    {
        if ($conditions->getChannel()) {
            $qb->andWhere($qb->expr()->eq($alias . '.channel', ':channel'))
                ->setParameter('channel', $conditions->getChannel());
        }
    }
}