<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\ClientToObjectConverter;
use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\UserToObjectConverter;

class CompanyActivitiesMap implements MapInterface
{
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