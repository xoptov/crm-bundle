<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\ActivityInterface;
use Perfico\CRMBundle\Entity\UserInterface;

class CallManagerConverter implements ConverterInterface
{
    public function convert($value)
    {
    }

    public function convertCollection($values)
    {
    }

    /**
     * @param ActivityInterface $object
     * @return null|array
     */
    public function reverseConvert($object)
    {
        if ($object instanceof ActivityInterface) {
            // Retrieve user for activity
            $user = $object->getUser();

            if ($user instanceof UserInterface) {
                return [
                    'id' => $user->getId(),
                    'firstName' => $user->getFirstName(),
                    'middleName' => $user->getMiddleName(),
                    'lastName' => $user->getLastName(),
                    'phone' => $user->getPhone()
                ];
            }
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {

    }
} 