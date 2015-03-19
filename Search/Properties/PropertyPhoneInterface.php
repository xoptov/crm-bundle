<?php

namespace Perfico\CRMBundle\Search\Properties;

interface PropertyPhoneInterface
{
    /**
     * @return string
     */
    public function getPhone();

    /**
     * @return bool
     */
    public function getPhoneNotSpecified();
} 