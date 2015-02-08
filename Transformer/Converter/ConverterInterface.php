<?php

namespace Perfico\CRMBundle\Transformer\Converter;

interface ConverterInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function convert($value);

    public function reverseConvert($object);
} 