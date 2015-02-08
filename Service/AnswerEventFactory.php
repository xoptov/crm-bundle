<?php

namespace Perfico\CRMBundle\Service;

use Perfico\CRMBundle\Entity\PBX\Sipuni\AnswerEvent;
use Symfony\Component\HttpFoundation\Request;

class AnswerEventFactory extends CallEventFactory
{
    public function create()
    {
        return new AnswerEvent();
    }
} 