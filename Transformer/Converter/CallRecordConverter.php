<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\PBX\Sipuni\HangupEventInterface;

class CallRecordConverter implements ConverterInterface
{
    public function convert($value)
    {

    }

    /**
     * @param HangupEventInterface $object
     * @return string|null
     */
    public function reverseConvert($object)
    {
        if ($object instanceof HangupEventInterface) {
            return $object->getRecordLink();
        }

        return null;
    }
} 