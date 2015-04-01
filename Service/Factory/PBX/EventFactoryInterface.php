<?php

namespace Perfico\CRMBundle\Service\Factory\PBX;

use Perfico\CRMBundle\Entity\PBX\Sipuni\CallEventInterface;
use Symfony\Component\HttpFoundation\Request;
use Perfico\CRMBundle\Entity\PBX\Call;

interface EventFactoryInterface
{
    /**
     * @return CallEventInterface
     */
    public function create();

    /**
     * @param CallEventInterface $event
     * @param Request $request
     * @param Call $call
     */
    public function hydration(CallEventInterface $event, Request $request, Call $call);
} 