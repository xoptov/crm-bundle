<?php

namespace Perfico\CRMBundle\Transformer\Mapping;
use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

class TaskMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setNote' => 'note',
            'setDeadLine' => [
                'converter' => new DateTimeConverter(),
                'path' => 'deadLine'
            ],
            'setRememberAt' => [
                'converter' => new DateTimeConverter(),
                'path' => 'rememberAt'
            ],
            'setUser' => [
                'converter' => 'perfico_crm.api.user_converter',
                'path' => 'user'
            ],
            'setCompany' => [
                'converter' => 'perfico_crm.api.company_converter',
                'path' => 'company'
            ],
            'setState' => [
                'converter' => 'perfico_crm.api.task_state_converter',
                'path' => 'state'
            ],
            'setActivities' => [
                'converter' => 'perfico_crm.api.activity_converter',
                'path' => 'activities',
                'collection' => true
            ],
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'note' => 'getNote',
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'updatedAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getUpdatedAt'
            ],
            'deadLine' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getDeadLine'
            ],
            'rememberAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getRememberAt'
            ],
            'user' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getUser'
            ],
            'company' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getCompany'
            ],
            'state' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getState'
            ],
            'activities' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getActivities',
                'collection' => true
            ],
        ];
    }
}