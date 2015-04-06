<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\SipuniBundle\Entity\HangupEventInterface;

class CallRecordConverter implements ConverterInterface
{
    public function convert($value)
    {
    }

    public function convertCollection($values)
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

    public function reverseConvertCollection($objects)
    {
    }
} 