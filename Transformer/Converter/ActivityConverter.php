<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Activity;

class ActivityConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof Activity) {
            return [
                'id' => $object->getId(),
                'note' => $object->getNote(),
                'type' => $object->getType()
            ];
        }
        return null;
    }
}