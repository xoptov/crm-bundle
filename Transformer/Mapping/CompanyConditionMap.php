<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class CompanyConditionMap implements MapInterface
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

    }
}