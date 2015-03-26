<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

class PhoneMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setNumber' => 'number',
            'setClient' => [
                'converter' => 'perfico_crm.api.client_converter',
                'path' => 'client'
            ]
        ];
    }

    public function getMap(){
        return [
            'id' => 'getId',
            'number' => 'getNumber',
            'client' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getClient'
            ]
        ];
    }
} 