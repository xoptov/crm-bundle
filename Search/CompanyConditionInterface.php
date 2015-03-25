<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Search\Properties\PaginationInterface;
use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;

interface CompanyConditionInterface extends PropertyAccountInterface, PaginationInterface
{
    public function getName();

    public function getTags();

    public function getDealStates();

    public function getDealFrom();

    public function getDealTo();

    public function getActivityFrom();

    public function getActivityTo();

    public function getDelayedPayment();
} 