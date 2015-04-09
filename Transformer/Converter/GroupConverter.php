<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Group;

class GroupConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof Group) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'roles' => $object->getRoles()
            ];
        }

        return null;
    }
} 