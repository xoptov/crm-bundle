<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\TaskState;

class TaskStateConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof TaskState) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }
}