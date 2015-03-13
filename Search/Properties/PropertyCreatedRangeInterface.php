<?php

namespace Perfico\CRMBundle\Search\Properties;

interface PropertyCreatedRangeInterface
{
    /**
     * @return \DateTime
     */
    public function getCreatedFrom();

    /**
     * @return \DateTime
     */
    public function getCreatedTo();
} 