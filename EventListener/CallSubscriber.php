<?php

namespace Perfico\CRMBundle\EventListener;

use Perfico\CRMBundle\Entity\CallInterface;
use Perfico\CRMBundle\Entity\CompanyInterface;
use Perfico\CRMBundle\PerficoCRMEvents;
use Perfico\CRMBundle\Transformer\Converter\ObjectScalarConverter;
use Perfico\SipuniBundle\Event\CallbackEvent;
use Perfico\SipuniBundle\Entity\CallEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Perfico\CRMBundle\Entity\Call;

class CallSubscriber implements EventSubscriberInterface
{
    /** @var \Redis */
    private $redis;

    public static function getSubscribedEvents()
    {
        return [
            PerficoCRMEvents::CALL => 'onCall'
        ];
    }

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public function onCall(CallbackEvent $event)
    {
        $callEvent = $event->getCallEvent();
        /** @var Call $call */
        $call = $callEvent->getCall();
        $account = $call->getAccount();

        if ($call->getDirection() != CallInterface::DIRECTION_INCOMING) {
            return;
        }

        $converter = new ObjectScalarConverter();

        if ($callEvent instanceof CallEventInterface) {
            $client = $call->getActivity()->getClient();
            $managerIds = [];

            if ($call->getCalledUsers()->count()) {
                $managerIds = $converter->reverseConvertCollection($call->getCalledUsers());
            }

            $company = null;
            if ($client->getCompany() instanceof CompanyInterface) {
                $company = $client->getCompany()->getName();
            }

            $message = [
                'managerIds' => $managerIds,
                'event' => 'incoming-call',
                'data' => [
                    'clientId' => $client->getId(),
                    'name' => $client->getFirstName() . ' ' . $client->getLastName(),
                    'company' => $company,
                    'position' => $client->getPosition()
                ]
            ];

            $this->redis->publish('events.' . $account->getDomain(), json_encode($message));
        }
    }
} 