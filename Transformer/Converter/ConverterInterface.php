<?php

namespace Perfico\CRMBundle\Transformer\Converter;

interface ConverterInterface
{
    /**
     * @param integer|float|string $value
     * @return mixed
     */
    public function convert($value);

    /**
     * @param array $values
     * @return mixed
     */
    public function convertCollection($values);

    /**
     * @param $object
     * @return integer
     */
    public function reverseConvert($object);

    /**
     * @param $objects
     * @return array
     */
    public function reverseConvertCollection($objects);
} 