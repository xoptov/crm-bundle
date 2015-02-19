<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class ChannelMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName'
        ];
    }
} 