<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\CompanyInterface;

class CompanyConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof CompanyInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'phone' => $object->getPhone(),
                'inn' => $object->getInn(),
                'details' => $object->getDetails(),
                'note' => $object->getNote(),
                'site' => $object->getSite()
            ];
        }

        return null;
    }
} 