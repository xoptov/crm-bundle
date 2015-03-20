<?php

namespace Perfico\CRMBundle\Transformer\Converter;

/**
 * @deprecated from 20150320
 */
class DateConverter implements ConverterInterface
{
    /**
     * @param $value
     * @return \DateTime
     */
    public function convert($value)
    {
        $date =  new \DateTime($value);

        return $date;
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
            return $object->format('d.m.Y');
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {
    }
} 