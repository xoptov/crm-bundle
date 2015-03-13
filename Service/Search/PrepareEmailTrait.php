<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyEmailInterface;

trait PrepareEmailTrait
{
    protected function prepareEmailCondition(QueryBuilder $qb, PropertyEmailInterface $conditions, $alias)
    {
        if ($conditions->getEmail()) {
            $qb->andWhere($qb->expr()->eq($alias . '.email', ':email'))
                ->setParameter('email', $conditions->getEmail());
        }
    }
} 