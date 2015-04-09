<?php

namespace Perfico\CRMBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Perfico\CRMBundle\Entity\CallInterface;
use Perfico\CRMBundle\Entity\ClientInterface;
use Perfico\CRMBundle\Entity\UserInterface;
use Perfico\CRMBundle\Exception\CallDirectionException;
use Perfico\CRMBundle\PerficoCRMEvents;
use Perfico\CRMBundle\Service\Manager\ClientManager;
use Perfico\CRMBundle\Service\Telephony\PhoneManager;
use Perfico\SipuniBundle\PerficoSipuniEvents;
use Perfico\SipuniBundle\Event\CallbackEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Perfico\CRMBundle\Service\Manager\ActivityManager;
use Perfico\CRMBundle\Service\Manager\AccountManager;
use Perfico\CRMBundle\Service\Telephony\CallManager;
use Perfico\CRMBundle\Entity\Call;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CallSubscriber implements EventSubscriberInterface
{
    /** @var ActivityManager */
    private $activityManager;

    /** @var AccountManager */
    private $accountManager;

    /** @var CallManager */
    private $callManager;

    /** @var ClientManager */
    private $clientManager;

    /** @var  EventDispatcherInterface */
    private $dispatcher;

    public function __construct(ActivityManager $activityManager, AccountManager $accountManager, CallManager $callManager, ClientManager $clientManager, EventDispatcherInterface $dispatcher)
    {
        $this->activityManager = $activityManager;
        $this->accountManager = $accountManager;
        $this->callManager = $callManager;
        $this->clientManager = $clientManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PerficoSipuniEvents::FIRST_CALL => 'onFirstCall',
            PerficoSipuniEvents::CALL => 'onCall',
            PerficoSipuniEvents::ANSWER => 'onAnswer',
            PerficoSipuniEvents::HANGUP => 'onHangup'
        ];
    }

    public function onFirstCall(CallbackEvent $event)
    {
        $callEvent = $event->getCallEvent();

        /** @var Call $call */
        $call = $callEvent->getCall();
        $callerSystem = $this->callManager->getCallerSystem($callEvent);

        $activity = $this->activityManager->create();
        $activity->setType('call');
        $this->activityManager->update($activity, false);

        $call->setActivity($activity);
        $call->setAccount($this->accountManager->getCurrentAccount());

        $user = $callerSystem->searchSourceUser($callEvent);

        if ($user instanceof UserInterface) {
            $call->setDirection(CallInterface::DIRECTION_OUTBOUND);
            $activity->setUser($user);
        } else {
            $call->setDirection(CallInterface::DIRECTION_INCOMING);
            $client = $callerSystem->searchSourceClient($callEvent);

            if ($client instanceof ClientInterface) {
                $activity->setClient($client);
            } else {
                // TODO need remove this if-then logic since clients can call from Skype or Sip
                if ($callerSystem instanceof PhoneManager) {
                    $client = $this->clientManager->create();
                    $this->clientManager->update($client, false);
                    $callerSystem->prepareNewClient($client, $callEvent->getSrcNumber());
                    $activity->setClient($client);
                }
            }
        }
    }

    public function onCall(CallbackEvent $event)
    {
        $callEvent = $event->getCallEvent();
        /** @var Call $call */
        $call = $callEvent->getCall();
        $calledSystem = $this->callManager->getCalledSystem($callEvent);

        if ($call->getDirection() == CallInterface::DIRECTION_INCOMING) {

            $user = $calledSystem->searchDestinationUser($callEvent);

            if ($user instanceof UserInterface) {
                $call->addCallee($user);
            } else {
                $this->dispatcher->dispatch(PerficoCRMEvents::CALLEE_USER_NOT_FOUND, $event);
            }

            $this->dispatcher->dispatch(PerficoCRMEvents::CALL, $event);

        } else if ($call->getDirection() == CallInterface::DIRECTION_OUTBOUND) {
            $client = $calledSystem->searchDestinationClient($callEvent);

            if ($client instanceof ClientInterface) {
                $call->getActivity()->setClient($client);
            } else {
                $this->dispatcher->dispatch(PerficoCRMEvents::CALLEE_CLIENT_NOT_FOUND);
            }
        } else {
            throw new CallDirectionException($callEvent);
        }
    }

    public function onAnswer(CallbackEvent $event)
    {
        $callEvent = $event->getCallEvent();
        /** @var Call $call */
        $call = $callEvent->getCall();
        $callSystem = $this->callManager->getCalledSystem($callEvent);

        if ($call->getDirection() == CallInterface::DIRECTION_INCOMING) {
            $user = $callSystem->searchDestinationUser($callEvent);

            if ($user instanceof UserInterface) {
                $call->getActivity()->setUser($user);
            } else {
                $this->dispatcher->dispatch(PerficoCRMEvents::CALLEE_USER_NOT_FOUND, $event);
            }
        }
    }

    public function onHangup(CallbackEvent $event)
    {
        return;
    }
} 