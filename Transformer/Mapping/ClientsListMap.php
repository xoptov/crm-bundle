<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\ClientsListChannelConverter;
use Perfico\CRMBundle\Transformer\Converter\ClientsListUserConverter;
use Perfico\CRMBundle\Transformer\Converter\PhoneConverter;
use Perfico\CRMBundle\Transformer\Converter\DateTimeConverter;

class ClientsListMap implements MapInterface
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
            'skype' => 'getSkype',
            'createdAt' => [
                'converter' => new DateTimeConverter(),
                'method' => 'getCreatedAt'
            ],
            'company' => 'getCompany',
            'channel' => [
                'converter' => new ClientsListChannelConverter(),
                'method' => 'getChannel'
            ],
            'dealStatuses' => [
                'converter' => 'perfico_crm.api.clients_list_statuses_converter',
                'method' => 'getDeals'
            ],
            'note' => 'getNote',
            'phones' => [
                'converter' => new PhoneConverter(),
                'method' => 'getPhones'
            ],
            'user' => [
                'converter' => new ClientsListUserConverter(),
                'method' => 'getUser'
            ]
        ];
    }
} 