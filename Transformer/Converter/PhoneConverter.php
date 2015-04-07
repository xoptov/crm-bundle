<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\PhoneInterface;

class PhoneConverter implements ConverterInterface
{
    /**
     * @param $value
     * @return array
     */
    public function convert($value)
    {
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
        if ($object) {
            return $this->clear($object);
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {
        $result = [];

        /** @var PhoneInterface $phone */
        foreach($objects as $phone)
        {
            $result[] = $this->clear($phone->getNumber());
        }

        return implode(' ', $result);
    }

    /**
     * Method for cleaning phone number
     * @param string $raw
     * @return string
     */
    protected function clear($raw)
    {
        return preg_replace('/^(?:\+7|8|\+)|[\-\s\(\)]+/', '', trim($raw));
    }
} 