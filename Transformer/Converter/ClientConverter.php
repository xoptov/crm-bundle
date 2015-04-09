<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Client;
use Perfico\CRMBundle\Entity\ClientInterface;

class ClientConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof ClientInterface) {
            return [
                'id' => $object->getId(),
                'firstName' => $object->getFirstName(),
                'middleName' => $object->getMiddleName(),
                'lastName' => $object->getLastName(),
                'note' => $object->getNote(),
                'position' => $object->getPosition(),
                'email' => $object->getEmail(),
                'customField1' => $object->getCustomField1(),
                'customField2' => $object->getCustomField2(),
                'customField4' => $object->getCustomField3(),
                'customField5' => $object->getCustomField1(),
                'customField6' => $object->getCustomField1(),
                'customField7' => $object->getCustomField1(),
                'customField8' => $object->getCustomField1(),
                'customField9' => $object->getCustomField1(),
                'customField10' => $object->getCustomField1(),
                'customField11' => $object->getCustomField1(),
                'customField12' => $object->getCustomField1(),
                'customField13' => $object->getCustomField1(),
                'customField14' => $object->getCustomField1(),
                'customField15' => $object->getCustomField1()
            ];
        }

        return null;
    }
}