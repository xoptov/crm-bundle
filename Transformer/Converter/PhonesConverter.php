<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class PhonesConverter implements ConverterInterface {

    /**
     * @param $value
     * @return array
     */
    public function convert($value)
    {
        return $value;
    }

    /**
     * @param array $object
     * @return array
     */
    public function reverseConvert($object)
    {
        $result = [];
        foreach($object as $phone)
        {
            if (count($phone->getNumber()) == 10)
            {
                $result[] = "+7".$phone->getNumber();
            }
            else
            {
                $result[] = $phone->getNumber();
            }
        }
        return implode(' ', $result);
    }
} 