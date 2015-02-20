<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class DealStateMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setIcon' => 'icon'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'icon' => 'getIcon'
        ];
    }
} 