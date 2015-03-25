<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Company;

class CompanyConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof Company) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'phone' => $object->getPhone(),
                'inn' => $object->getInn(),
                'details' => $object->getDetails()
            ];
        }

        return null;
    }
} 