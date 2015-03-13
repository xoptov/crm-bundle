<?php

namespace Perfico\CRMBundle\Search\Properties;

interface PropertyDealRangeInterface
{
    /**
     * @return \DateTime
     */
    public function getDealFrom();

    /**
     * @return \DateTime
     */
    public function getDealTo();
} 