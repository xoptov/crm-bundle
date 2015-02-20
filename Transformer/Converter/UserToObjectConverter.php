<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\UserBundle\Entity\User;

class UserToObjectConverter implements ConverterInterface
{
    public function convert($value)
    {

    }

    /**
     * @param User $object
     * @return array|null
     */
    public function reverseConvert($object)
    {
        if ($object instanceof User)
        {
            return [
                'id' => $object->getId(),
                'name' => $object->getName()
            ];
        }

        return null;
    }
}