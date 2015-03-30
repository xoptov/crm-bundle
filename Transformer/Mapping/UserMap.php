<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\GroupDetailConverter;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;
use Perfico\CRMBundle\Transformer\Converter\PhoneConverter;

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
            'setPhone' => 'phone',
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
            'photo' => 'getPhoto',
            'phone' => [
                'converter' => new PhoneConverter(),
                'method' => 'getPhone'
            ],
            'groups' => [
                'converter' => 'perfico_crm.api.group_converter',
                'method' => 'getGroups',
                'collection' => true
            ]
        ];
    }
} 