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