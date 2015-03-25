<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DealsListConverter;

class DealsListMap extends DealMap
{
    public function getReverseMap() {}

    public function getMap()
    {
        $map = parent::getMap();

        $map['paid'] = [
            'converter' => new DealsListConverter(),
            'method' => 'getPayments'
        ];

        return $map;
    }
} 