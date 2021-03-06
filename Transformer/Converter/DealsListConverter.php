<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\PaymentInterface;

class DealsListConverter implements ConverterInterface
{
    public function convert($value)
    {
    }

    public function convertCollection($values)
    {
    }

    public function reverseConvert($objects)
    {
        $paid = 0;
        foreach ($objects as $object)
        {
           if ($object instanceof PaymentInterface)
           {
               $paid += $object->getAmount();
           }
        }

        return $paid;
    }

    public function reverseConvertCollection($objects)
    {
    }
} 