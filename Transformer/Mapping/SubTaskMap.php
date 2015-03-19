<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class SubTaskMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setTaskId' => [
                'converter' => 'perfico_crm.api.task_converter',
                'path' => 'taskId'
            ],
            'setNote' => 'note',
            'setCompleted' => 'completed'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'taskId' => [
                'converter' => 'perfico_crm.api.task_converter',
                'method' => 'getTaskId'
            ],
            'name' => 'getNote',
            'completed' => 'getCompleted'
        ];
    }
}