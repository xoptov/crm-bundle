<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\TagInterface;

class TagConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof TagInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }
} 