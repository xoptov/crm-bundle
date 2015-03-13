<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;

trait PrepareAccountTrait
{
    protected function prepareAccountCondition(QueryBuilder $qb, PropertyAccountInterface $conditions, $alias)
    {
        if ($conditions->getAccount()) {
            $qb->andWhere($qb->expr()->eq( $alias . '.account', ':account'))
                ->setParameter('account', $conditions->getAccount());
        }
    }
} 