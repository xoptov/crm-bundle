<?php

namespace Perfico\DosalesBundle\Event;

use Perfico\DosalesBundle\Entity\PBX\Sipuni\CallEventInterface;
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