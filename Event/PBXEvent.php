<?php

namespace Perfico\CRMBundle\Event;

use Perfico\CRMBundle\Entity\PBX\Sipuni\CallEventInterface;
use Symfony\Component\EventDispatcher\Event;

class PBXEvent extends Event
{
    /** @var CallEventInterface */
    protected $callEvent;

    /**
     * @const
     */
    const CALL_EVENT = 'perfico.pbx.call_event';

    /**
     * @param CallEventInterface $callEvent
     */
    public function setCallEvent(CallEventInterface $callEvent)
    {
        $this->callEvent = $callEvent;
    }

    /**
     * @return CallEventInterface
     */
    public function getCallEvent()
    {
        return $this->callEvent;
    }
} 