<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Group;

class GroupDetailConverter extends AbstractEntityConverter
{
    /**
     * @param Group $object
     * @return array|null
     */
    public function reverseConvert($object)
    {
        if ($object instanceof Group) {
            return [
                'id' => $object->getId(),
                'group_name' => $object->getName()
            ];
        }

        return null;
    }

}




