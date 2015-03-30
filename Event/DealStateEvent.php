<?php

namespace Perfico\CRMBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Perfico\CRMBundle\Entity\DealStateInterface;

class DealStateEvent extends Event
{
    /** @var DealStateInterface */
    protected $dealStateEvent;

    /**
     * @const
     */
    const DEAL_STATE_UPDATE_EVENT = 'crm.deal_state.require_payment_changed';
    const DEAL_STATE_ADD_EVENT = 'crm.deal_state.require_payment_added';

    /**
     * @param DealStateInterface $dealStateEvent
     */
    public function setPayment(DealStateInterface $dealStateEvent)
    {
        $this->dealStateEvent = $dealStateEvent;
    }

    /**
     * @return DealStateInterface
     */
    public function getPayment()
    {
        return $this->dealStateEvent;
    }
} 