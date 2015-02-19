<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Channel;

class ClientsListChannelConverter implements ConverterInterface
{
    public function convert($value)
    {

    }

    public function reverseConvert($object)
    {
        if ($object instanceof Channel) {
            return $object->getName();
        }

        return null;
    }
}