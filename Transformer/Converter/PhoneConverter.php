<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\PhoneInterface;

class PhoneConverter extends AbstractEntityConverter
{
    /**
     * @param array $object
     * @return array
     */
    public function reverseConvert($object)
    {
        if ($object instanceof PhoneInterface) {
            return [
                'id' => $object->getId(),
                'number' => $object->getNumber()
            ];
        }

        return null;
    }
} 