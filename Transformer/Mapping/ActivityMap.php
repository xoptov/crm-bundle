<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateConverter;

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
                'converter' => new DateConverter(),
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
                'converter' => new DateConverter(),
                'method' => 'getRememberAt'
            ],
            'updatedAt' => [
                'converter' => new DateConverter(),
                'method' => 'getUpdatedAt'
            ],
            'createdAt' => [
                'converter' => new DateConverter(),
                'method' => 'getCreatedAt'
            ],
            'user' => [
                'converter' => 'perfico_crm.api.user_converter',
                'method' => 'getUser'
            ],
            'client' => [
                'converter' => 'perfico_crm.api.client_converter',
                'method' => 'getClient'
            ]
        ];
    }
} 