<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class ClientConditionMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setUser' => 'user',
            'setEmail' => 'email',
            'setEmailNotSpecified' => 'emailNotSpecified',
            'setPhone' => 'phone',
            'setPhoneNotSpecified' => 'phoneNotSpecified',
            'setChannel' => 'channel',
            'setCreatedFrom' => [
                'converter' => new DateTimeConverter(),
                'path' => 'createdFrom'
            ],
            'setCreatedTo' => [
                'converter' => new DateTimeConverter(),
                'path' => 'createdTo'
            ],
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