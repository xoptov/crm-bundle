<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyCreatedRangeInterface;

trait PrepareCreatedRangeTrait
{
    protected function prepareCreatedRangeCondition(QueryBuilder $qb, PropertyCreatedRangeInterface $conditions, $alias)
    {
        if ($conditions->getCreatedFrom() && $conditions->getCreatedTo()) {

            $condition = $qb->expr()->between($alias . '.createdAt', ':createdFrom', ':createdTo');
            $qb->andWhere($condition)
                ->setParameter('createdFrom', $conditions->getCreatedFrom())
                ->setParameter('createdTo', $conditions->getCreatedTo());

        } else if ($conditions->getCreatedFrom()) {

            $qb->andWhere($qb->expr()->lte($alias . '.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $conditions->getCreatedFrom());

        } else if ($conditions->getCreatedTo()) {

            $qb->andWhere($qb->expr()->gte($alias . '.createdAt', ':createdTo'))
                ->setParameter('createdTo', $conditions->getCreatedTo());

        }
    }
} 