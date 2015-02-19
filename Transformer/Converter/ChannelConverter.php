<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class ChannelConverter extends AbstractEntityConverter
{
    /**
     * @param $value
     * @return mixed|void
     */
    public function convert($value)
    {
        if ($value)
        {
            return $this->em->getReference($this->entityClass, $value);
        }
        else
        {
            return null;
        }

    }

}