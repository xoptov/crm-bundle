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
            'setGroups' => [
                'converter' => 'perfico_crm.api.group_converter',
                'path' => 'groups',
                'collection' => true
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
            'groups' => [
                'converter' => 'perfico_crm.api.group_converter',
                'method' => 'getGroups',
                'collection' => true
            ]
        ];
    }
} 