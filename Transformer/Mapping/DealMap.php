<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

class DealMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setAmount' => 'amount',
            'setNote' => 'note',
            'setState' => [
                'converter' => 'perfico_crm.api.deal_state_converter',
                'path' => 'state'
            ],
            'setClient' => [
                'converter' => 'perfico_crm.api.client_converter',
                'path' => 'client'
            ],
            'setUser' => [
                'converter' => 'perfico_crm.api.user_converter',
                'path' => 'user'
            ],
            'setProduct' => [
                'converter' => 'perfico_crm.api.product_converter',
                'path' => 'product'
            ]
        ];
    }

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
                'converter' => new ObjectScalarConverter(),
                'method' => 'getClient'
            ],
            'state' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getState'
            ],
            'product' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getProduct'
            ],
            'user' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getUser'
            ]
        ];
    }
} 