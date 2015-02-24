<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Client;

class ClientToObjectConverter implements ConverterInterface
{
    public function convert($value)
    {
    }

    public function convertCollection($values)
    {
    }

    /**
     * @param Client $object
     * @return array
     */
    public function reverseConvert($object)
    {
        if ($object instanceof Client)
        {
            return [
                'id' => $object->getId(),
                'firstName' => $object->getFirstName(),
                'middleName' => $object->getMiddleName(),
                'lastName' => $object->getLastName()
            ];
        }
    }

    public function reverseConvertCollection($objects)
    {
    }
}