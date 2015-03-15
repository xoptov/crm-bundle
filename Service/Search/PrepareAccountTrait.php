<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;

trait PrepareAccountTrait
{
    protected function prepareAccountCondition(QueryBuilder $qb, PropertyAccountInterface $condition, $alias)
    {
        if ($condition->getAccount()) {
            $qb->andWhere($qb->expr()->eq( $alias . '.account', ':account'))
                ->setParameter('account', $condition->getAccount());
        }
    }
} 