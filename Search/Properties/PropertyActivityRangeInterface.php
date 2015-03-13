<?php

namespace Perfico\CRMBundle\Search\Properties;

interface PropertyActivityRangeInterface
{
    /**
     * @return \DateTime
     */
    public function getActivityFrom();

    /**
     * @return \DateTime
     */
    public function getActivityTo();
} 