<?php

namespace Perfico\CRMBundle\Search\Properties;

interface PaginationInterface
{
    /**
     * @return mixed
     */
    public function getOffset();

    /**
     * @return mixed
     */
    public function getLimit();
} 