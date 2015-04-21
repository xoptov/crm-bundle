<?php

namespace Perfico\CRMBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Perfico\CRMBundle\Entity\Channel;
use Perfico\CRMBundle\PerficoCRMEvents;
use Perfico\CRMBundle\Search\ChannelCondition;
use Perfico\SipuniBundle\Event\CallbackEvent;
use Perfico\CRMBundle\Service\Manager\ChannelManager;
use Perfico\CRMBundle\Service\Manager\AccountManager;
use Perfico\CRMBundle\Entity\Call;

class ClientSubscriber implements EventSubscriberInterface
{
    /** @var ChannelManager */
    private $channelManager;

    /** @var AccountManager */
    private $accountManager;

    public function __construct(ChannelManager $channelManager, AccountManager $accountManager)
    {
        $this->channelManager = $channelManager;
        $this->accountManager = $accountManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            PerficoCRMEvents::NEW_THE_CALLER => 'onNewCaller'
        ];
    }

    public function onNewCaller(CallbackEvent $event)
    {
        $callEvent = $event->getCallEvent();
        /** @var Call $call */
        $call = $callEvent->getCall();

        // Prepare new client information
        $client = $call->getClient();
        $client->setFirstName('from call center');

        if ($callEvent->getTreeName() || $callEvent->getTreeNumber()) {
            $condition = new ChannelCondition();
            $condition->setAccount($this->accountManager->getCurrentAccount());
            $condition->setTreeName($callEvent->getTreeName())
                ->setTreeNumber($callEvent->getTreeNumber());

            $channel = $this->channelManager->searchOne($condition);

            if ($channel instanceof Channel) {
                $call->getClient()->setChannel($channel);
            }
        }
    }
}