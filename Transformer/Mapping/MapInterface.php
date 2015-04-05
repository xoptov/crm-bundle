<?php

namespace Perfico\CRMBundle\Transformer\Mapping;

interface MapInterface
{
    /**
     * JSON -> Object converting map
     * @return array
     */
    public function getReverseMap();

    /**
     * Object -> JSON converting map
     * @return array
     */
    public function getMap();
}