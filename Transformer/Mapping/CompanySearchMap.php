<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class CompanySearchMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setDealFrom' => [
                'converter' => new DateTimeConverter(),
                'path' => 'dealFrom'
            ],
            'setDealTo' => [
                'converter' => new DateTimeConverter(),
                'path' => 'dealTo'
            ],
            'setActivityFrom' => [
                'converter' => new DateTimeConverter(),
                'path' => 'activityFrom'
            ],
            'setActivityTo' => [
                'converter' => new DateTimeConverter(),
                'path' => 'activityTo'
            ],
            'setTags' => 'tags',
            'setDealStates' => 'dealStates',
            'setDelayedPayment' => 'delayedPayment',
            'setOffset' => 'offset',
            'setLimit' => 'limit'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'inn' => 'getInn',
            'phone' => 'getPhone',
            'details' => 'getDetails',
            'dealStates' => [
                'converter' => 'perfico_crm.api.company_deal_states_converter',
                'method' => 'getClients',
                'collection' => true
            ],
            'lastActivity' => [
                'converter' => 'perfico_crm.api.company_last_activity_converter',
                'method' => 'getId'
            ]
        ];
    }
} 