<?php

namespace Perfico\DosalesBundle\Transformer\Converter;

class DateTimeConverter implements ConverterInterface
{
    /**
     * @param $value
     * @return \DateTime
     */
    public function convert($value)
    {
        $date_utc =  new \DateTime($value);
        $date_utc->setTimeZone(new \DateTimeZone('Europe/Moscow'));

        return $date_utc;
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
} 