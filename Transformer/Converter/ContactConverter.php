<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\ContactInterface;

class ContactConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof ContactInterface) {
            return [
                'id' => $object->getId(),
                'phone' => $object->getPhone(),
                'sip' => $object->getSip(),
                'skype' => $object->getSkype()
            ];
        }

        return null;
    }
} 