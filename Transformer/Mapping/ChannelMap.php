<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class ChannelMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setExternalLink' => 'externalLink'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'externalLink' => 'getExternalLink'
        ];
    }
} 