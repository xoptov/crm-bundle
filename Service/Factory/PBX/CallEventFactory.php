<?php

namespace Perfico\CRMBundle\Service\Factory\PBX;

use Perfico\CRMBundle\Entity\PBX\Call;
use Perfico\CRMBundle\Entity\PBX\Sipuni\CallEvent;
use Perfico\CRMBundle\Entity\PBX\Sipuni\CallEventInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * This is class using for polymorphism in oop
 */
class CallEventFactory implements EventFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new CallEvent();
    }

    /**
     * {@inheritdoc}
     */
    public function hydration(CallEventInterface $event, Request $request, Call $call)
    {
        $event->setCall($call)
            ->setType($request->get('type'))
            ->setSrcNumber(trim($request->get('src_num')))
            ->setSrcType($request->get('src_type'))
            ->setDstNumber(trim($request->get('dst_num')))
            ->setDstType($request->get('dst_type'));

        if ($request->get('timestamp')) {
            $date = new \DateTime();
            $date->setTimestamp($request->get('timestamp'));
            $event->setEventDate($date);
        }
    }
} 