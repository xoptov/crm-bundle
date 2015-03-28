<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class ActivityListMap implements MapInterface
{
    /**
     * @return array
     */
    public function getReverseMap()
    {

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
                'converter' => 'perfico_crm.api.user_converter',
                'method' => 'getUser'
            ]
        ];
    }
} 