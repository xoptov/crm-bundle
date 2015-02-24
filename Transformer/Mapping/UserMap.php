<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class UserMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setPlainPassword' => 'plainPassword',
            'setFirstName' => 'firstName',
            'setMiddleName' => 'middleName',
            'setLastName' => 'lastName',
            'setEmail' => 'email',
            'setUsername' => 'email',
            'setGroup' => [
                'converter' => 'perfico_crm.api.group_converter',
                'path' => 'group'
            ]
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'email' => 'getEmail',
            'name' => 'getName',
            'firstName' => 'getFirstName',
            'middleName' => 'getMiddleName',
            'lastName' => 'getLastName',
            'group' => [
                'converter' => 'perfico_crm.api.group_converter',
                'method' => 'getGroup'
            ]
        ];
    }
} 