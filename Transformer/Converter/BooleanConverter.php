<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class BooleanConverter implements ConverterInterface
{
    protected $defaultValue;

    public function __construct($defaultValue = null)
    {
        $this->defaultValue = $defaultValue;
    }

    public function convert($value)
    {
        if ($value !== null) {
            return (bool)$value;
        }

        return $this->defaultValue;
    }

    public function convertCollection($values)
    {

    }

    public function reverseConvert($object)
    {

    }

    public function reverseConvertCollection($objects)
    {

    }
} 