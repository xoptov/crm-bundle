<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;
use Perfico\CRMBundle\Transformer\Converter\PhoneScalarConverter;

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
                'method' => 'getDeals',
                'collection' => true
            ],
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