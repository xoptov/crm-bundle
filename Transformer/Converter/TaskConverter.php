<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Task;

class TaskConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof Task) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'note' => $object->getNote()
            ];
        }

        return null;
    }
}