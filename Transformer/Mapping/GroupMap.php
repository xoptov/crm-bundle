<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

use Perfico\CRMBundle\Transformer\Converter\RolesConverter;

class GroupMap implements MapInterface
{
    public function getReverseMap()
    {
        return [
            'setName' => 'name',
            'setRoles' => [
                'converter' => new RolesConverter(),
                'path' => 'roles'
            ],
        ];
    }

    public function getMap()
    {
        return [
            'id' => 'getId',
            'name' => 'getName',
            'roles' => 'getRoles'
        ];
    }
} 