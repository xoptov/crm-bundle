<?php

namespace Perfico\CRMBundle\Transformer\Factory;

interface ObjectFactoryInterface
{
    /**
     * Method for creating new object
     * @param array|null $aggregator
     * @return mixed
     */
    public function create($aggregator = null);

    /**
     * Method for loading object form storage
     * @param array $ids
     * @return mixed
     */
    public function load(array $ids);
}