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
        return $this->clear($value);
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
            return '+7' . $this->clear($object);
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {
        $result = [];

        /** @var PhoneInterface $phone */
        foreach($objects as $phone)
        {
            $result[] = '+7' . $this->clear($phone->getNumber());
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