<?php

namespace Perfico\CRMBundle\Service\Manager;

interface GenericManagerInterface
{
    public function create();

    public function remove($entity);

    public function update($entity);
} 