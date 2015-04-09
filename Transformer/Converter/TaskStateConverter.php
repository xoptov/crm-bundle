<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\TaskStateInterface;

class TaskStateConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof TaskStateInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }
}