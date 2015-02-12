<?php

namespace Perfico\CRMBundle\Transformer\Factory;

interface RepositoryInterface
{
    /**
     * @param array $ids
     */
    public function getByIds(array $ids);
}