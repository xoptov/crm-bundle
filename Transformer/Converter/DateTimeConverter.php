<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class DateTimeConverter implements ConverterInterface
{
    /**
     * @param $value
     * @return \DateTime|null
     */
    public function convert($value)
    {
        if ($value) {
            return new \DateTime($value);
        }

        return null;
    }

    public function convertCollection($values)
    {
    }

    /**
     * @param \DateTime $object
     * @return string|null
     */
    public function reverseConvert($object)
    {
        if ($object instanceof \DateTime){
            return $object->format(\DateTime::ISO8601);
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {
    }
} 