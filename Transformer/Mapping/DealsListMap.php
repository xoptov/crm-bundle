<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\ClientToObjectConverter;
use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\DealsListConverter;
use Perfico\CRMBundle\Transformer\Converter\DealStateToObjectConverter;
use Perfico\CRMBundle\Transformer\Converter\UserToObjectConverter;

class DealsListMap implements MapInterface
{
    public function getReverseMap() {}

    public function getMap()
    {
        return [
            'id' => 'getId',
            'amount' => 'getAmount',
            'paid' => [
                'converter' => new DealsListConverter(),
                'method' => 'getPayments'
            ],
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'note' => 'getNote',
            'client' => [
                'converter' => new ClientToObjectConverter(),
                'method' => 'getClient'
            ],
            'state' => [
                'converter' => new DealStateToObjectConverter(),
                'method' => 'getState'
            ],
            'user' => [
                'converter' => new UserToObjectConverter(),
                'method' => 'getUser'
            ]
        ];
    }
} 