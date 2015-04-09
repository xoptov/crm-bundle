<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\DealInterface;

class DealConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof DealInterface) {
            return [
                'id' => $object->getId(),
                'note' => $object->getNote(),
                'amount' => $object->getAmount()
            ];
        }

        return null;
    }
} 