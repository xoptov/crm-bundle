<?php

namespace Perfico\CRMBundle\EventListener;

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
            CallbackEvent::CALL_EVENT => 'onFirstCall'
        ];
    }

    public function onFirstCall(CallbackEvent $event)
    {
        if (get_class($event->getCallEvent()) == 'Perfico\SipuniBundle\Entity\CallEvent') {
            $call = $event->getCallEvent()->getCall();
            if ($call->getCallEvents()->count() == 0) {

                $client = $call->getActivity()->getClient();
                $message = [
                    'manager_id' => 0,
                    'event' => 'incoming-call',
                    'data' => [
                        'client_id' => $client->getId(),
                        'name' => $client->getFirstName(),
                        'company' => null,
                        'position' => $client->getPosition()
                    ]
                ];

                $this->redis->publish('events', json_encode($message));
            }
        }
    }
} 