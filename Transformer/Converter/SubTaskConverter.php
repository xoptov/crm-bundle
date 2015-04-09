<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\SubTaskInterface;

class SubTaskConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof SubTaskInterface) {
            return [
                'id' => $object->getId(),
                'note' => $object->getNote(),
                'completed' => $object->getCompleted()
            ];
        }

        return null;
    }
}