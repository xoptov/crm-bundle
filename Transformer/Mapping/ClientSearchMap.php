<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class ClientSearchMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setUser' => 'user',
            'setEmail' => 'email',
            'setPhone' => 'phone',
            'setChannel' => 'channel',
            'setCreatedFrom' => [
                'converter' => new DateTimeConverter(),
                'path' => 'createdFrom'
            ],
            'setCreatedTo' => [
                'converter' => new DateTimeConverter(),
                'path' => 'createdTo'
            ],
            'setDealsFrom' => [
                'converter' => new DateTimeConverter(),
                'path' => 'dealsFrom'
            ],
            'setDealsTo' => [
                'converter' => new DateTimeConverter(),
                'path' => 'dealsTo'
            ],
            'setActivityFrom' => [
                'converter' => new DateTimeConverter(),
                'path' => 'activityFrom'
            ],
            'setActivityTo' => [
                'converter' => new DateTimeConverter(),
                'path' => 'activityTo'
            ],
            'setDealStates' => 'dealStates',
            'setTags' => 'tags',
            'setDelayedPayment' => 'delayedPayment',
            'setOffset' => 'offset',
            'setLimit' => 'limit'
        ];
    }

    public function getMap()
    {
    }
} 