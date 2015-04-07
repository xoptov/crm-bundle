<?php

namespace Perfico\CRMBundle\EventListener;

use Perfico\SipuniBundle\PerficoSipuniEvents;
use Perfico\SipuniBundle\Event\CallbackEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CallSubscriber implements EventSubscriberInterface
{
    private $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public static function getSubscribedEvents()
    {
        return [
            PerficoSipuniEvents::FIRST_CALL => 'onFirstCall'
        ];
    }

    public function onFirstCall(CallbackEvent $event)
    {
        // TODO this need implementation for call processing
        return;
    }
} 