<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\User;

class UserConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof User) {
            return [
                'id' => $object->getId(),
                'firstName' => $object->getFirstName(),
                'middleName' => $object->getMiddleName(),
                'lastName' => $object->getLastName(),
                'email' => $object->getEmail(),
                'photo' => $object->getPhoto()
            ];
        }

        return null;
    }
}