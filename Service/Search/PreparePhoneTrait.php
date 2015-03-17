<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PropertyPhoneInterface;

trait PreparePhoneTrait
{
    protected function preparePhoneCondition(QueryBuilder $qb, PropertyPhoneInterface $condition, $alias)
    {
        if ($condition->getPhone()) {
            $qb->innerJoin($alias . '.phones', 'p');
            $number = preg_replace('/^(?:\+7|\+?8)|[\(\)\-\s\W]+/', '', $condition->getPhone());
            $qb->andWhere($qb->expr()->like('p.number', ':number'))
                ->setParameter('number', '%' . $number . '%');
        } else if ($condition->getPhoneNotSpecified()) {
            $qb->leftJoin($alias . '.phones', 'p');
            $qb->andWhere($qb->expr()->isNull('p.id'));
        }
    }

    protected function prepareNumberCondition(QueryBuilder $qb, PropertyPhoneInterface $condition, $alias)
    {
        if ($condition->getPhone()) {
            $number = preg_replace('/^(?:\+7|\+?8)|[\(\)\-\s\W]+/', '', $condition->getPhone());
            $qb->andWhere($qb->expr()->like($alias . '.phone', ':phone'))
                ->setParameter('phone', '%' . $number . '%');
        }
    }
} 