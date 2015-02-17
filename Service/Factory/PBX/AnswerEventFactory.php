<?php

namespace Perfico\CRMBundle\Service\Factory\PBX;

use Perfico\CRMBundle\Entity\PBX\Sipuni\AnswerEvent;

class AnswerEventFactory extends CallEventFactory
{
    public function create()
    {
        return new AnswerEvent();
    }
} 