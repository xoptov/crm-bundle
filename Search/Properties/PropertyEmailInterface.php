<?php

namespace Perfico\CRMBundle\Search\Properties;

interface PropertyEmailInterface
{
    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return bool
     */
    public function getEmailNotSpecified();
} 