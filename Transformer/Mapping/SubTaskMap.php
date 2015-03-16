<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class SubTaskMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setNote' => 'note',
            'setCompleted' => 'completed'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getNote',
            'completed' => 'getCompleted'
        ];
    }
}