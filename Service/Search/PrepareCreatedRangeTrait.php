<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyCreatedRangeInterface;

trait PrepareCreatedRangeTrait
{
    protected function prepareCreatedRangeCondition(QueryBuilder $qb, PropertyCreatedRangeInterface $condition, $alias)
    {
        if ($condition->getCreatedFrom() && $condition->getCreatedTo()) {

            $createdTo = $condition->getCreatedTo();
            $createdTo->setTime(23, 59, 59);

            $qb->andWhere($qb->expr()->between($alias . '.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getCreatedFrom())
                ->setParameter('createdTo', $createdTo);

        } else if ($condition->getCreatedFrom()) {

            $qb->andWhere($qb->expr()->gte($alias . '.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getCreatedFrom());

        } else if ($condition->getCreatedTo()) {

            $createdTo = $condition->getCreatedTo();
            $createdTo->setTime(23, 59, 59);

            $qb->andWhere($qb->expr()->lte($alias . '.createdAt', ':createdTo'))
                ->setParameter('createdTo', $createdTo);

        }
    }
} 