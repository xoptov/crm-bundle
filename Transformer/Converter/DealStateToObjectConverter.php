<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\DealState;

class DealStateToObjectConverter implements ConverterInterface
{
    public function convert($value)
    {
    }

    public function convertCollection($values)
    {
    }

    /**
     * @param DealState[] $object
     * @return array
     */
    public function reverseConvert($object)
    {
        if ($object instanceof DealState)
        {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'icon' => $object->getIcon()
            ];
        }
    }

    public function reverseConvertCollection($objects)
    {
    }
}