<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PaginationInterface;

trait PreparePaginationTrait
{
    protected function preparePagination(QueryBuilder $qb, PaginationInterface $condition)
    {
        if ($condition->getOffset()) {
            $qb->setFirstResult($condition->getOffset());
        }

        if ($condition->getLimit()) {
            $qb->setMaxResults($condition->getLimit());
        }
    }
} 