<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

class ContactMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setUser' => [
                'converter' => 'perfico_crm.api.user_converter',
                'path' => 'user'
            ],
            'setPhone' => 'phone',
            'setSip' => 'sip',
            'setSkype' => 'skype'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'user' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getUser'
            ],
            'phone' => 'getPhone',
            'sip' => 'getSip',
            'skype' => 'getSkype'
        ];
    }
} 