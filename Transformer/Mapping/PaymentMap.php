<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

class PaymentMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setNote' => 'note',
            'setAmount' => 'amount',
            'setDeal' => [
                'converter' => 'perfico_crm.api.deal_converter',
                'path' => 'deal'
            ]
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'note' => 'getNote',
            'amount' => 'getAmount',
            'deal' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getDeal'],
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt']
        ];
    }
} 