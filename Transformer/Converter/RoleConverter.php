<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class RoleConverter implements ConverterInterface
{
    /**
     * @param $value
     * @return array
     */
    public function convert($value)
    {
        if (empty($value)) {
            return null;
        }

        $raw = explode(',', $value);

        if (is_array($raw)) {
            $roles = [];
            foreach ($raw as $item) {
                $roles[] = trim($item);
            }

            return $roles;
        }

        return null;
    }

    public function convertCollection($values)
    {
    }

    /**
     * @param array $object
     * @return array
     */
    public function reverseConvert($object)
    {
        return $object;
    }
    
    public function reverseConvertCollection($objects)
    {
    }
} 