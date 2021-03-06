<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

class ActivityMap implements MapInterface
{
    /**
     * @return array
     */
    public function getReverseMap(){

        return [
            'setType' => 'type',
            'setNote' => 'note',
            'setRememberAt' => [
                'converter' => new DateTimeConverter(),
                'path' => 'rememberAt'
            ],
            'setClient' => [
                'converter' => 'perfico_crm.api.client_converter',
                'path' => 'client'
            ],
            'setUser' => [
                'converter' => 'perfico_crm.api.user_converter',
                'path' => 'user'
            ]

        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'type' => 'getType',
            'note' => 'getNote',
            'rememberAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getRememberAt'
            ],
            'updatedAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getUpdatedAt'
            ],
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'user' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getUser'
            ],
            'client' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getClient'
            ]
        ];
    }
} 