<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\PhoneInterface;

class PhoneScalarConverter extends ObjectScalarConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof PhoneInterface) {
            return $object->getNumber();
        }

        return null;
    }
} 