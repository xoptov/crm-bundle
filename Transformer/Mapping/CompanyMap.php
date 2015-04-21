<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;

class CompanyMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setInn' => 'inn',
            'setPhone' => 'phone',
            'setDetails' => 'details',
            'setNote' => 'note',
            'setSite' => 'site',
            'setTags' => [
                'converter' => 'perfico_crm.api.tag_converter',
                'path' => 'tags',
                'collection' => true
            ]
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
            'note' => 'getNote',
            'site' => 'getSite',
            'tags' => [
                'converter' => new ObjectScalarConverter(),
                'method' => 'getTags',
                'collection' => true
            ]
        ];
    }
} 