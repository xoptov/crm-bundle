<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

class ClientCustomFieldMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
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
            'customFields1' => 'getCustomField1',
            'customFields2' => 'getCustomField2',
            'customFields3' => 'getCustomField3',
            'customFields4' => 'getCustomField4',
            'customFields5' => 'getCustomField5',
            'customFields6' => 'getCustomField6',
            'customFields7' => 'getCustomField7',
            'customFields8' => 'getCustomField8',
            'customFields9' => 'getCustomField9',
            'customFields10' => 'getCustomField10',
            'customFields11' => 'getCustomField11',
            'customFields12' => 'getCustomField12',
            'customFields13' => 'getCustomField13',
            'customFields14' => 'getCustomField14',
            'customFields15' => 'getCustomField15',
        ];
    }
} 