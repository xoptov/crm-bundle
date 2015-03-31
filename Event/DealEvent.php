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
    const DEAL_ADD_EVENT = 'crm.deal.status_created';
    const DEAL_UPDATED_EVENT = 'crm.deal.status_updated';

    /**
     * @param DealInterface $dealEvent
     */
    public function setDeal(DealInterface $dealEvent)
    {
        $this->dealEvent = $dealEvent;
    }

    /**
     * @return DealInterface
     */
    public function getDeal()
    {
        return $this->dealEvent;
    }
} 