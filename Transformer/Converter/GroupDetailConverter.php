<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Group;

class GroupDetailConverter extends AbstractEntityConverter
{
    public function convert($value)
    {
    }

    public function convertCollection($values)
    {
    }

    /**
     * @param Group $object
     * @return array|null
     */
    public function reverseConvert($object)
    {
        if ($object instanceof Group) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {
    }
}




