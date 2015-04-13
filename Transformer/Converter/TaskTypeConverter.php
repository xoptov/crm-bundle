<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\TaskTypeInterface;

class TaskTypeConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof TaskTypeInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'icon' => $object->getIcon()
            ];
        }

        return null;
    }
}