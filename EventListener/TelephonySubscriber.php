<?php

namespace Perfico\CRMBundle\EventListener;

use Perfico\CRMBundle\Entity\CallInterface;
use Perfico\CRMBundle\Entity\ClientInterface;
use Perfico\CRMBundle\Entity\UserInterface;
use Perfico\CRMBundle\Exception\CallDirectionException;
use Perfico\CRMBundle\PerficoCRMEvents;
use Perfico\CRMBundle\Service\Manager\ClientManager;
use Perfico\CRMBundle\Service\Telephony\PhoneManager;
use Perfico\CRMBundle\Service\Telephony\SipManager;
use Perfico\SipuniBundle\Entity\AnswerEvent;
use Perfico\SipuniBundle\PerficoSipuniEvents;
use Perfico\SipuniBundle\Event\CallbackEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Perfico\CRMBundle\Service\Manager\ActivityManager;
use Perfico\CRMBundle\Service\Manager\AccountManager;
use Perfico\CRMBundle\Service\Telephony\CallManager;
use Perfico\CRMBundle\Entity\Call;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TelephonySubscriber implements EventSubscriberInterface
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
        unset($activity);

        $call->setAccount($this->accountManager->getCurrentAccount());

        $user = $callerSystem->searchSourceUser($callEvent);

        if ($user instanceof UserInterface) {
            $call->setDirection(CallInterface::DIRECTION_OUTBOUND);
            $call->setUser($user);

            // Dispatch PerficoSipuniEvents::CALL when using SIP system for outbound call
            if ($callerSystem instanceof SipManager) {
                $e = new CallbackEvent();
                $e->setCallEvent($callEvent);
                $this->dispatcher->dispatch(PerficoSipuniEvents::CALL, $e);
            }

        } else {
            $call->setDirection(CallInterface::DIRECTION_INCOMING);
            $client = $callerSystem->searchSourceClient($callEvent);

            if ($client instanceof ClientInterface) {
                $call->setClient($client);
            } else {

                if ($callerSystem instanceof PhoneManager) { // TODO need remove this condition since clients can call from Skype or Sip
                    $client = $this->clientManager->create();
                    $this->clientManager->update($client, false);
                    $callerSystem->prepareNewClient($client, $callEvent->getSrcNumber());
                    $call->setClient($client);

                    $e = new CallbackEvent();
                    $e->setCallEvent($callEvent);
                    $this->dispatcher->dispatch(PerficoCRMEvents::NEW_THE_CALLER, $e);
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
                $call->setClient($client);
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
                $call->setUser($user);
            } else {
                $this->dispatcher->dispatch(PerficoCRMEvents::CALLEE_USER_NOT_FOUND, $event);
            }
        }
    }

    public function onHangup(CallbackEvent $event)
    {
        $callEvent = $event->getCallEvent();
        /** @var Call $call */
        $call = $callEvent->getCall();

        if ($call->getDirection() == CallInterface::DIRECTION_INCOMING) {
            if ($call->getUser() instanceof UserInterface && $call->getAnswerEvent() instanceof AnswerEvent) {
                $this->callManager->calcTalkDuration($call);
                $call->setNumber($call->getAnswerEvent()->getDstNumber());
                $this->activityManager->prepareIncomingCallNote($call);
            }
        } else if ($call->getDirection() == CallInterface::DIRECTION_OUTBOUND) {
            if ($call->getAnswerEvent() instanceof AnswerEvent) {
                $this->callManager->calcTalkDuration($call);
            }
        } else {
            throw new CallDirectionException($callEvent);
        }
    }

} 