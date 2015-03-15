<?php

namespace Perfico\CRMBundle\Search\Properties;

use Perfico\CRMBundle\Entity\AccountInterface;

interface PropertyAccountInterface
{
    /**
     * @return AccountInterface
     */
    public function getAccount();
} 