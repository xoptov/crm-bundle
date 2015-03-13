<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyPhoneInterface;

trait PreparePhoneTrait
{
    protected function preparePhoneCondition(QueryBuilder $qb, PropertyPhoneInterface $conditions, $alias)
    {
        if ($conditions->getPhone()) {
            $qb->innerJoin($alias . '.phones', 'p');
            $number = preg_replace('/^(?:\+7|\+?8)|[\(\)\-\s\W]+/', '', $conditions->getPhone());
            $qb->andWhere($qb->expr()->like('p.number', ':number'))
                ->setParameter('number', '%' . $number . '%');
        }
    }

    protected function prepareNumberCondition(QueryBuilder $qb, PropertyPhoneInterface $conditions, $alias)
    {
        if ($conditions->getPhone()) {
            $number = preg_replace('/^(?:\+7|\+?8)|[\(\)\-\s\W]+/', '', $conditions->getPhone());
            $qb->andWhere($qb->expr()->like($alias . '.phone', ':phone'))
                ->setParameter('phone', '%' . $number . '%');
        }
    }
} 