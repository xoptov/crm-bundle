<?php

namespace Perfico\CRMBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Perfico\CRMBundle\Entity\PaymentInterface;

class PaymentEvent extends Event
{
    /** @var PaymentInterface */
    protected $paymentEvent;

    /**
     * @const
     */
    const PAYMENT_CREATE_EVENT = 'crm.payment.created';
    const PAYMENT_UPDATE_EVENT = 'crm.payment.updated';

    /**
     * @param PaymentInterface $paymentEvent
     */
    public function setPayment(PaymentInterface $paymentEvent)
    {
        $this->paymentEvent = $paymentEvent;
    }

    /**
     * @return PaymentInterface
     */
    public function getPayment()
    {
        return $this->paymentEvent;
    }
} 