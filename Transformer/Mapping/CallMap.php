<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\CallManagerConverter;
use Perfico\CRMBundle\Transformer\Converter\CallRecordConverter;

class CallMap implements MapInterface
{
    public function getReverseMap()
    {

    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'user' => [
                'converter' => 'perfico_crm.api.call_manager_converter',
                'method' => 'getActivity'
            ],
            'number' => 'getNumber',
            'record' => [
                'converter' => new CallRecordConverter(),
                'method' => 'getHangupEvent'
            ]
        ];
    }
} 