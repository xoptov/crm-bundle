<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyUserInterface;

trait PrepareUserTrait
{
    protected function prepareUserCondition(QueryBuilder $qb, PropertyUserInterface $condition, $alias)
    {
        if ($condition->getUser()) {
            $qb->andWhere($qb->expr()->eq($alias . '.user', ':user_id'))
                ->setParameter('user_id', $condition->getUser());
        }
    }
} 