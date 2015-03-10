<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\ClientToObjectConverter;
use Perfico\CRMBundle\Transformer\Converter\DateConverter;
use Perfico\CRMBundle\Transformer\Converter\UserToObjectConverter;

class ActivitiesListMap implements MapInterface
{
    public function getReverseMap(){}

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
                'method' => 'getLastDate'
            ],
            'createdAt' => [
                'converter' => new DateConverter(),
                'method' => 'getLastDate'
            ],
            'user' => [
                'converter' => new UserToObjectConverter(),
                'method' => 'getUser'
            ],
            'client' => [
                'converter' => new ClientToObjectConverter(),
                'method' => 'getClient'
            ]
        ];
    }
} 