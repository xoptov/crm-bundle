<?php

namespace Perfico\CRMBundle\Service;

use Perfico\CRMBundle\Entity\PBX\Call;
use Perfico\CRMBundle\Entity\PBX\Sipuni\CallEvent;
use Perfico\CRMBundle\Entity\PBX\Sipuni\HangupEvent;
use Symfony\Component\HttpFoundation\Request;

class HangupEventFactory extends CallEventFactory
{
    public function create()
    {
        return new HangupEvent();
    }

    public function hydration(CallEvent $event, Request $request, Call $call)
    {
        /**
         * @var HangupEvent $event
         */

        parent::hydration($event, $request, $call);

        $event->setStatus($request->get('status'));

        if ($request->get('call_start_timestamp')) {
            $date = new \DateTime();
            $date->setTimestamp($request->get('call_start_timestamp'));
            $event->setStartDate($date);
        }

        $event->setRecordLink($request->get('call_record_link'));
    }
} 