<?php
namespace Perfico\CRMBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Perfico\CRMBundle\Entity\DealInterface;


class DealEvent extends Event
{
    /** @var DealInterface */
    protected $dealEvent;

    /**
     * @const
     */
    const DEAL_EVENT = 'crm.deal.status_updated';

    /**
     * @param DealInterface $dealEvent
     */
    public function setPayment(DealInterface $dealEvent)
    {
        $this->dealEvent = $dealEvent;
    }

    /**
     * @return DealInterface
     */
    public function getPayment()
    {
        return $this->dealEvent;
    }
} 