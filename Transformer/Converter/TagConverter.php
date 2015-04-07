<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Tag;

class TagConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof Tag) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }
} 