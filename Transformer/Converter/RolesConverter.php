<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class RolesConverter implements ConverterInterface
{
    /**
     * @param $value
     * @return array
     */
    public function convert($value)
    {
        if (is_array($value)) {
            return $value;
        }
        $result = json_decode($value, true, 3);
        if (!$result) {
            $result = preg_replace('/^\s+|\s+$|\s+(?=,)|(?<=,)\s+/su', '', $value);
            $result = explode(',', $result);
        }
        return $result;
    }

    /**
     * @param array $object
     * @return array
     */
    public function reverseConvert($object)
    {
        return $object;
    }
} 