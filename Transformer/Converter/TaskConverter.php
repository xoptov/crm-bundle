<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\TaskInterface;

class TaskConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof TaskInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'note' => $object->getNote()
            ];
        }

        return null;
    }
}