<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Search\Properties\PaginationInterface;
use Perfico\CRMBundle\Search\Properties\PropertyAccountInterface;
use Perfico\CRMBundle\Search\Properties\PropertyActivityRangeInterface;
use Perfico\CRMBundle\Search\Properties\PropertyChannelInterface;
use Perfico\CRMBundle\Search\Properties\PropertyCreatedRangeInterface;
use Perfico\CRMBundle\Search\Properties\PropertyDealRangeInterface;
use Perfico\CRMBundle\Search\Properties\PropertyDealStatesInterface;
use Perfico\CRMBundle\Search\Properties\PropertyDelayedPaymentInterface;
use Perfico\CRMBundle\Search\Properties\PropertyEmailInterface;
use Perfico\CRMBundle\Search\Properties\PropertyNameInterface;
use Perfico\CRMBundle\Search\Properties\PropertyPhoneInterface;
use Perfico\CRMBundle\Search\Properties\PropertyTagsInterface;
use Perfico\CRMBundle\Search\Properties\PropertyUserInterface;

interface ClientConditionInterface extends PropertyAccountInterface,
    PropertyNameInterface,
    PropertyUserInterface,
    PropertyEmailInterface,
    PropertyPhoneInterface,
    PropertyChannelInterface,
    PropertyCreatedRangeInterface,
    PropertyDealRangeInterface,
    PropertyActivityRangeInterface,
    PropertyDealStatesInterface,
    PropertyTagsInterface,
    PropertyDelayedPaymentInterface,
    PaginationInterface
{

} 