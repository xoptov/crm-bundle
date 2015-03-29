<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Search\Properties\PaginationInterface;
use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;

interface CompanyConditionInterface extends PropertyAccountInterface, PaginationInterface
{
    public function getName();

    public function getTags();

    public function getDealStates();

    /**
     * @return \DateTime
     */
    public function getDealFrom();

    /**
     * @return \DateTime
     */
    public function getDealTo();

    /**
     * @return \DateTime
     */
    public function getActivityFrom();

    /**
     * @return \DateTime
     */
    public function getActivityTo();

    public function getDelayedPayment();
} 