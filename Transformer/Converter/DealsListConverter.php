<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Payment;

class DealsListConverter implements ConverterInterface
{
    public function convert($value)
    {

    }

    public function reverseConvert($objects)
    {
        $paid = 0;
        foreach ($objects as $object)
        {
           if ($object instanceof Payment)
           {
               $paid += $object->getAmount();
           }
        }

        return $paid;
    }
} 