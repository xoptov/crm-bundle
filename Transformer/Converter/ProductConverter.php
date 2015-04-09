<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\ProductInterface;

class ProductConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        if ($object instanceof ProductInterface) {
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'amount' => $object->getAmount(),
                'sku' => $object->getSku()
            ];
        }

        return null;
    }
}