<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Search\Properties\PaginationInterface;
use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;
use Perfico\CRMBundle\Search\Properties\PropertyChannelInterface;
use Perfico\CRMBundle\Search\Properties\PropertyCreatedRangeInterface;
use Perfico\CRMBundle\Search\Properties\PropertyEmailInterface;
use Perfico\CRMBundle\Search\Properties\PropertyPhoneInterface;
use Perfico\CRMBundle\Search\Properties\PropertyUserInterface;

interface ClientConditionInterface extends PropertyAccountInterface, PropertyUserInterface, PropertyEmailInterface, PropertyPhoneInterface, PropertyChannelInterface, PropertyCreatedRangeInterface, PaginationInterface
{
    public function getName();

    public function getCompany();

    public function getDealFrom();

    public function getDealTo();

    public function getActivityFrom();

    public function getActivityTo();

    public function getDealStates();

    public function getTags();

    public function getDelayedPayment();
} 