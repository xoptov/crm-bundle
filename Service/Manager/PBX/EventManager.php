<?php

namespace Perfico\CRMBundle\Service\Manager\PBX;

use Perfico\CoreBundle\Entity\Client;
use Perfico\CoreBundle\Entity\Phone;
use Perfico\CRMBundle\Service\Manager\UserManager;
use Perfico\CRMBundle\Entity\PBX\Sipuni\AnswerEvent;
use Perfico\CRMBundle\Entity\PBX\Sipuni\CallEventInterface;
use Perfico\CRMBundle\Entity\PBX\Sipuni\HangupEvent;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Perfico\CRMBundle\Service\Manager\ClientManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Perfico\CRMBundle\Service\Factory\PBX\AnswerEventFactory;
use Perfico\CRMBundle\Service\Factory\PBX\CallEventFactory;
use Perfico\CRMBundle\Service\Factory\PBX\HangupEventFactory;

class EventManager
{
    /** @var EntityManager */
    protected $em;

    /** @var ClientManager */
    protected $cm;

    /** @var UserManager */
    protected $um;

    /** @var Translator */
    protected $translator;

    public function __construct(EntityManager $em, ClientManager $cm, UserManager $um, Translator $translator)
    {
        $this->em = $em;
        $this->cm = $cm;
        $this->um = $um;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @return AnswerEventFactory|CallEventFactory|HangupEventFactory
     */
    public function getFactory(Request $request)
    {
        switch ($request->get('event')) {
            case CallEventInterface::TYPE_HANGUP:
                $factory = new HangupEventFactory();
                break;
            case CallEventInterface::TYPE_ANSWER:
                $factory = new AnswerEventFactory();
                break;
            default:
                $factory = new CallEventFactory();
        }

        return $factory;
    }

    /**
     * @param CallEventInterface $event
     */
    public function processing(CallEventInterface $event)
    {
        $client = $this->cm->searchByPhone($event->getSrcNumber());
        $activity = $event->getCall()->getActivity();

        if ($client == null) {
            $client = new Client();
            $this->em->persist($client);

            $phone = new Phone();
            $this->em->persist($phone);

            $client->setFirstName('без имени')
                ->setAccount($event->getCall()->getAccount());

            $phone->setNumber('+' . $event->getSrcNumber())
                ->setAccount($event->getCall()->getAccount())
                ->setClient($client);
        }

        $activity->setClient($client);
    }

    /**
     * @param CallEventInterface $event
     */
    public function determineUser(CallEventInterface $event)
    {
        $user = $this->um->searchByPhone($event->getDstNumber());

        if (! $user) {
            $user = $event->getCall()->getActivity()->getClient()->getUser();
        }

        if ($user) {
            $event->getCall()->getActivity()->setUser($user);
        }
    }

    /**
     * @param AnswerEvent $event
     */
    public function relateAnswerEvent(AnswerEvent $event)
    {
        $call = $event->getCall();
        $call->setAnswerEvent($event);
    }

    /**
     * @param HangupEvent $event
     */
    public function relateHangupEvent(HangupEvent $event)
    {
        $call = $event->getCall();
        $call->setHangupEvent($event);
    }

    /**
     * @param HangupEvent $event
     */
    public function prepareActivityNote(HangupEvent $event)
    {
        $call = $event->getCall();
        $activity = $call->getActivity();

        // Prepare information
        $dateTime = $event->getEventDate()->format('d.m.Y H:i');
        $status = $this->translator->trans('activity.status.' . $event->getStatus());

// Commented by CRM-450 task
//        $record = $event->getRecordLink();

        $duration = null;

        $answer = $call->getAnswerEvent();
        $hangup = $call->getHangupEvent();

        /** @var CallEventInterface $answer $hangup */
        if ($answer && $hangup) {
            $date1 = $answer->getEventDate();
            $date2 = $hangup->getEventDate();
            if ($date1 && $date2) {
                $duration = $date1->diff($date2)->format('%H:%I:%s');
            }
        }

        // Prepare note string
        $note = $this->translator->trans('activity.note.datetime', array('%dateTime%' => $dateTime));
        $note .= $this->translator->trans('activity.note.status', array('%status%' => $status));

        if ($duration)
            $note .= $this->translator->trans('activity.note.duration', array('%duration%' => $duration));

// Commented by CRM-450 task
//        if ($record)
//            $note .= $this->translator->trans('activity.note.record', array('%record%' => $record));

        if ($user = $activity->getUser())
            $note .= $this->translator->trans('activity.note.user', array('%firstName%' => $user->getFirstName(), '%phone%' => $user->getPhone()));

        $activity->setNote($note);
    }
} 