<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\SubTask;

class SubTaskConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof SubTask) {
            return [
                'id' => $object->getId(),
                'note' => $object->getNote(),
                'completed' => $object->getCompleted()
            ];
        }

        return null;
    }
}