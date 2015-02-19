<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

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
                'converter' => 'perfico_crm.api.client_converter',
                'method' => 'getClient'
            ]
        ];
    }
} 