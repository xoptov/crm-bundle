<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\DealStateInterface;

class DealStateConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof DealStateInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'icon' => $object->getIcon()
            ];
        }

        return null;
    }
} 