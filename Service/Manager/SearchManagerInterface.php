<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CRMBundle\Search\SearchConditionInterface;

interface SearchManagerInterface
{
    public function search(SearchConditionInterface $conditions);

    public function initQueryBuilder(SearchConditionInterface $conditions);
} 