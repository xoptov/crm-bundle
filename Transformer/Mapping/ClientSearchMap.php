<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\BooleanConverter;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;
use Perfico\CRMBundle\Transformer\Converter\PhoneScalarConverter;

class ClientSearchMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setUser' => 'user',
            'setEmail' => 'email',
            'setEmailNotSpecified' => [
                'converter' => new BooleanConverter(false),
                'path' => 'emailNotSpecified'
            ],
            'setPhone' => 'phone',
            'setPhoneNotSpecified' => [
                'converter' => new BooleanConverter(false),
                'path' => 'phoneNotSpecified'
            ],
            'setChannel' => 'channel',
            'setCompany' => 'company',
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
            'setDelayedPayment' => [
                'converter' => new BooleanConverter(false),
                'path' => 'delayedPayment'
            ],
            'setOffset' => 'offset',
            'setLimit' => 'limit'
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'email' => 'getEmail',
            'firstName' => 'getFirstName',
            'lastName' => 'getLastName',
            'middleName' => 'getMiddleName',
            'skype' => 'getSkype',
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'company' => [
                'converter' => 'perfico_crm.api.company_converter',
                'method' => 'getCompany'
            ],
            'channel' => [
                'converter' => 'perfico_crm.api.channel_converter',
                'method' => 'getChannel'
            ],
            'dealStatuses' => [
                'converter' => 'perfico_crm.api.clients_list_statuses_converter',
                'method' => 'getDeals',
                'collection' => true
            ],
            'tags' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getTags',
                'collection' => true
            ],
            'note' => 'getNote',
            'phones' => [
                'converter' => new PhoneScalarConverter(),
                'method' => 'getPhones',
                'collection' => true
            ],
            'user' => [
                'converter' => 'perfico_crm.api.user_converter',
                'method' => 'getUser'
            ]
        ];
    }
} 