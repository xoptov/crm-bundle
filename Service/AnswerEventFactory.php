<?php

namespace Perfico\DosalesBundle\Service;

use Perfico\DosalesBundle\Entity\PBX\Sipuni\AnswerEvent;
use Symfony\Component\HttpFoundation\Request;

class AnswerEventFactory extends CallEventFactory
{
    public function create()
    {
        return new AnswerEvent();
    }
} 