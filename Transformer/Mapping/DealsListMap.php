<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DealsListConverter;
use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class DealsListMap extends DealMap
{
    public function getReverseMap() {}

    public function getMap()
    {
        return [
            'id' => 'getId',
            'amount' => 'getAmount',
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'note' => 'getNote',
            'client' => [
                'converter' => 'perfico_crm.api.client_converter',
                'method' => 'getClient'
            ],
            'state' => [
                'converter' => 'perfico_crm.api.deal_state_converter',
                'method' => 'getState'
            ],
            'product' => [
                'converter' => 'perfico_crm.api.product_converter',
                'method' => 'getProduct'
            ],
            'user' => [
                'converter' => 'perfico_crm.api.user_converter',
                'method' => 'getUser'
            ],
            'paid' => [
                'converter' => new DealsListConverter(),
                'method' => 'getPayments'
            ]
        ];
    }
} 