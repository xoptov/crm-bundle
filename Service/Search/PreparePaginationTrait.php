<?php

namespace Perfico\CRMBundle\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\Properties\PaginationInterface;

trait PreparePaginationTrait
{
    protected function preparePagination(QueryBuilder $qb, PaginationInterface $conditions)
    {
        if ($conditions->getOffset()) {
            $qb->setFirstResult($conditions->getOffset());
        }

        if ($conditions->getLimit()) {
            $qb->setMaxResults($conditions->getLimit());
        }
    }
} 