<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Deal;

class DealConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof Deal) {
            return [
                'id' => $object->getId(),
                'note' => $object->getNote(),
                'amount' => $object->getAmount()
            ];
        }

        return null;
    }
} 