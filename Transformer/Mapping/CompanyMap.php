<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class CompanyMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setInn' => 'inn',
            'setPhone' => 'phone',
            'setDetails' => 'details'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'inn' => 'getInn',
            'phone' => 'getPhone',
            'details' => 'getDetails'
        ];
    }
} 