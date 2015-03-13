<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Search\Properties\PaginationInterface;
use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;
use Perfico\CRMBundle\Search\Properties\PropertyActivityRangeInterface;
use Perfico\CRMBundle\Search\Properties\PropertyDealRangeInterface;
use Perfico\CRMBundle\Search\Properties\PropertyDealStatesInterface;
use Perfico\CRMBundle\Search\Properties\PropertyDelayedPaymentInterface;
use Perfico\CRMBundle\Search\Properties\PropertyNameInterface;
use Perfico\CRMBundle\Search\Properties\PropertyTagsInterface;

interface CompanyConditionInterface extends PropertyAccountInterface,
    PropertyNameInterface,
    PropertyTagsInterface,
    PropertyDealStatesInterface,
    PropertyDealRangeInterface,
    PropertyActivityRangeInterface,
    PropertyDelayedPaymentInterface,
    PaginationInterface
{

} 