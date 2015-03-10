<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\DateConverter;

class ClientMap implements MapInterface
{
    public function getReverseMap()
    {

        return [
            'setEmail' => 'email',
            'setFirstName' => 'firstName',
            'setLastName' => 'lastName',
            'setMiddleName' => 'middleName',
            'setSkype' => 'skype',
            'setChannel' => [
                'converter' => 'perfico_crm.api.channel_converter',
                'path' => 'channel'
            ],
            'setNote' => 'note',
            'setTags' => [
                'converter' => 'perfico_crm.api.tag_converter',
                'path' => 'tags',
                'collection' => true
            ],
            'setUser' => [
                'converter' => 'perfico_crm.api.user_converter',
                'path' => 'user'
            ],
            'setCompany' => [
                'converter' => 'perfico_crm.api.company_converter',
                'path' => 'company'
            ],
            'setPosition' => 'position',
            'setCustomField1' => 'customField1',
            'setCustomField2' => 'customField2',
            'setCustomField3' => 'customField3',
            'setCustomField4' => 'customField4',
            'setCustomField5' => 'customField5',
            'setCustomField6' => 'customField6',
            'setCustomField7' => 'customField7',
            'setCustomField8' => 'customField8',
            'setCustomField9' => 'customField9',
            'setCustomField10' => 'customField10',
            'setCustomField11' => 'customField11',
            'setCustomField12' => 'customField12',
            'setCustomField13' => 'customField13',
            'setCustomField14' => 'customField14',
            'setCustomField15' => 'customField15'
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
                'converter' => new DateConverter(),
                'method' => 'getCreatedAt'],
            'channel' => [
                'converter' => 'perfico_crm.api.channel_converter',
                'method' => 'getChannel'
            ],
            'note' => 'getNote',
            'tags' => [
                'converter' => 'perfico_crm.api.tag_converter',
                'method' => 'getTags',
                'collection' => true
            ],
            'user' => [
                'converter' => 'perfico_crm.api.user_converter',
                'method' => 'getUser'
            ],
            'company' => [
                'converter' => 'perfico_crm.api.company_converter',
                'method' => 'getCompany'
            ],
            'position' => 'getPosition',
            'customField1' => 'getCustomField1',
            'customField2' => 'getCustomField2',
            'customField3' => 'getCustomField3',
            'customField4' => 'getCustomField4',
            'customField5' => 'getCustomField5',
            'customField6' => 'getCustomField6',
            'customField7' => 'getCustomField7',
            'customField8' => 'getCustomField8',
            'customField9' => 'getCustomField9',
            'customField10' => 'getCustomField10',
            'customField11' => 'getCustomField11',
            'customField12' => 'getCustomField12',
            'customField13' => 'getCustomField13',
            'customField14' => 'getCustomField14',
            'customField15' => 'getCustomField15',
        ];
    }
} 