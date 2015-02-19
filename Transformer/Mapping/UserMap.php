<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class UserMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setEmail' => 'email',
            'setPlainPassword' => 'plainPassword',
            'setUserName' => 'userName',
            'setFirstName' => 'firstName',
            'setMiddleName' => 'middleName',
            'setLastName' => 'lastName',
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