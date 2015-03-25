<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\PhoneConverter;
use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class CompanyContactsMap implements MapInterface
{
    public function getReverseMap() {}

    public function getMap()
    {
        return [
            'id' => 'getId',
            'email' => 'getEmail',
            'firstName' => 'getFirstName',
            'lastName' => 'getLastName',
            'middleName' => 'getMiddleName',
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'channel' => [
                'converter' => 'perfico_crm.api.channel_converter',
                'method' => 'getChannel'
            ],
            'dealStatuses' => [
                'converter' => 'perfico_crm.api.clients_list_statuses_converter',
                'method' => 'getDeals'
            ],
            'phones' => [
                'converter' => new PhoneConverter(),
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