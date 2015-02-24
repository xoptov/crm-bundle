<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\UserBundle\Entity\User;

class ClientsListUserConverter implements ConverterInterface
{
    public function convert($value)
    {
    }

    public function convertCollection($values)
    {
    }

    public function reverseConvert($object)
    {
        if ($object instanceof User) {
            $fio = [
                $object->getLastName(),
                $object->getFirstName(),
                $object->getMiddleName()
            ];
            return [
                    'id' => $object->getId(),
                    'name' => implode(' ', $fio)
                ];
        }
    }

    public function reverseConvertCollection($objects)
    {
    }
}