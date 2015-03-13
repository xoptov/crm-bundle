<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyNameInterface;

trait PrepareNameTrait
{
    protected function prepareNameCondition(QueryBuilder $qb, PropertyNameInterface $conditions, $alias)
    {
        if ($conditions->getName()) {

            $or = $qb->expr()->orX();
            $or->addMultiple([
                $qb->expr()->like($alias . '.firstName', ':name_expr'),
                $qb->expr()->like($alias . '.middleName', ':name_expr'),
                $qb->expr()->like($alias . '.lastName', ':name_expr')
            ]);

            $qb->andWhere($or)->setParameter('name_expr', '%' . $conditions->getName() . '%');
        }
    }
} 