<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\BooleanConverter;

class SubTaskMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setTask' => [
                'converter' => 'perfico_crm.api.task_converter',
                'path' => 'task'
            ],
            'setNote' => 'note',
            'setCompleted' => [
                'converter' => new BooleanConverter(false),
                'path' => 'completed'
            ]
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'task' => [
                'converter' => 'perfico_crm.api.task_converter',
                'method' => 'getTask'
            ],
            'name' => 'getNote',
            'completed' => 'getCompleted'
        ];
    }
}