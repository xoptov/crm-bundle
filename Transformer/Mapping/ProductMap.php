<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class ProductMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setAmount' => 'amount',
            'setName' => 'name',
            'setSku' => 'sku',
            'setParent' => [
                'converter' => 'perfico_crm.api.product_converter',
                'path' => 'parent'
            ],
            'setCreatedAt' => [
                'converter' => new DateTimeConverter(),
                'path' => 'createdAt'
            ],
            'setUpdatedAt' => [
                'converter' => new DateTimeConverter(),
                'path' => 'updatedAt'
            ]
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'amount' => 'getAmount',
            'children' => 'hasChildren',
            'parent' => [
                'converter' => 'perfico_crm.api.product_converter',
                'method' => 'getParent'
            ],
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'updatedAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getUpdatedAt'
            ],
            'name' => 'getName',
            'sku' => 'getSku'
        ];
    }
} 