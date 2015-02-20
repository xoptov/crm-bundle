<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class CustomFieldMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setNumber' => 'number'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'number' => 'getNumber'
        ];
    }
} 