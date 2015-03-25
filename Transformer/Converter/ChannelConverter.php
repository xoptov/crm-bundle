<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Channel;

class ChannelConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof Channel) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }
}