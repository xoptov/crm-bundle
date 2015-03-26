<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Exception\ImplementationException;
use Doctrine\Common\Collections\Collection;

class ObjectScalarConverter implements ConverterInterface
{
    public function convert($value)
    {
        throw new ImplementationException();
    }

    public function convertCollection($values)
    {
        throw new ImplementationException();
    }

    public function reverseConvert($object)
    {
        if (is_object($object) && method_exists($object, 'getId')) {
            return $object->getId();
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {
        $collection = [];

        if ($objects instanceof Collection) {
            foreach ($objects as $object) {
                if ($item = $this->reverseConvert($object)) {
                    $collection[] = $item;
                }
            }
        }

        return $collection;
    }
} 