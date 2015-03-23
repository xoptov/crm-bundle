<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

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
            'setCompleted' => 'completed'
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