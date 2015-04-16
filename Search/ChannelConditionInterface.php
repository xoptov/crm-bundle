<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;

interface ChannelConditionInterface extends PropertyAccountInterface
{
    /**
     * @return string
     */
    public function getTreeName();

    /**
     * @return string
     */
    public function getTreeNumber();
} 