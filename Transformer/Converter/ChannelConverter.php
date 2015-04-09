<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\ChannelInterface;

class ChannelConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof ChannelInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }
}