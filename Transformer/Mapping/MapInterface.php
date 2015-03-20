<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

interface MapInterface
{
    /**
     * @return array
     */
    public function getReverseMap();

    /**
     * @return array
     */
    public function getMap();
}