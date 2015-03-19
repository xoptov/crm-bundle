<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyEmailInterface;

trait PrepareEmailTrait
{
    protected function prepareEmailCondition(QueryBuilder $qb, PropertyEmailInterface $condition, $alias)
    {
        if ($condition->getEmail()) {
            $qb->andWhere($qb->expr()->eq($alias . '.email', ':email'))
                ->setParameter('email', $condition->getEmail());
        } else if ($condition->getEmailNotSpecified()) {
            $qb->andWhere($qb->expr()->isNull($alias . '.email'));
        }
    }
} 