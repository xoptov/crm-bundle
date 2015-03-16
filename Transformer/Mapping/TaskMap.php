<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class TaskMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setNote' => 'note',
            'setDeadLine' => 'deadLine',
            'setRememberAt' => 'rememberAt',
            'setAssignie' => [
                'converter' => 'perfico_crm.api.user_converter',
                'path' => 'user'
            ],
            'setState' => [
                'converter' => 'perfico_crm.api.task_state_converter',
                'path' => 'state'
            ],
            'setActivities' => [
                'converter' => 'perfico_crm.api.activities_converter',
                'path' => 'activities'
            ],
            'setSubTask' => [
                'converter' => 'perfico_crm.api.sub_task_converter',
                'path' => 'subTask'
            ],
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'note' => 'getNote',
            'createdAt' => [
                'converter' => new DateConverter(),
                'method' => 'getCreatedAt'
            ],
            'updatedAt' => [
                'converter' => new DateConverter(),
                'method' => 'getUpdatedAt'
            ],
            'deadLine' => [
                'converter' => new DateConverter(),
                'method' => 'getDeadLine'
            ],
            'rememberAt' => [
                'converter' => new DateConverter(),
                'method' => 'getRememberAt'
            ],
            'assignie' => [
                'converter' => 'perfico_crm.api.user_converter',
                'method' => 'getAssignie'
            ],
            'state' => [
                'converter' => 'perfico_crm.api.task_state_converter',
                'method' => 'getState'
            ],
            'activities' => [
                'converter' => 'perfico_crm.api.activity_converter',
                'method' => 'getActivities'
            ],
            'subTask' => [
                'converter' => 'perfico_crm.api.sub_task_converter',
                'method' => 'getSubTask'
            ]
        ];
    }
}