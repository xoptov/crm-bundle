<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\BooleanConverter;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

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
                'converter' => new ObjectScalarConverter(),
                'method' => 'getTask'
            ],
            'name' => 'getNote',
            'completed' => 'getCompleted'
        ];
    }
}