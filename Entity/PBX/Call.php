<?php

namespace Perfico\DosalesBundle\Entity\PBX;

use Perfico\DosalesBundle\Entity\ActivityInterface;
use Perfico\DosalesBundle\Entity\AccountInterface;
use Perfico\DosalesBundle\Entity\PBX\Sipuni\CallEventInterface;
use Perfico\DosalesBundle\Entity\PBX\Sipuni\AnswerEvent;
use Perfico\DosalesBundle\Entity\PBX\Sipuni\HangupEventInterface;

abstract class Call
{
    /** integer */
    protected $id;

    /** @var string */
    protected $pbxCallId;

    /** @var \DateTime */
    protected $createdAt;

    /** @var ActivityInterface */
    protected $activity;

    /** @var AccountInterface */
    protected $account;

    /** @var CallEventInterface[] */
    protected $callEvents;

    /** @var AnswerEvent */
    protected $answerEvent;

    /** @var HangupEventInterface */
    protected $hangupEvent;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $pbxCallId
     * @return Call
     */
    public function setPbxCallId($pbxCallId)
    {
        $this->pbxCallId = $pbxCallId;

        return $this;
    }

    /**
     * @return string
     */
    public function getPbxCallId()
    {
        return $this->pbxCallId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param ActivityInterface $activity
     * @return Call
     */
    public function setActivity(ActivityInterface $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return ActivityInterface
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param AccountInterface $account
     * @return Call
     */
    public function setAccount(AccountInterface $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return AccountInterface
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param AnswerEvent $event
     * @return Call
     */
    public function setAnswerEvent(AnswerEvent $event)
    {
        $this->answerEvent = $event;

        return $this;
    }

    /**
     * @return AnswerEvent
     */
    public function getAnswerEvent()
    {
        return $this->answerEvent;
    }

    /**
     * @param HangupEventInterface $event
     * @return Call
     */
    public function setHangupEvent(HangupEventInterface $event)
    {
        $this->hangupEvent = $event;

        return $this;
    }

    /**
     * @return HangupEventInterface
     */
    public function getHangupEvent()
    {
        return $this->hangupEvent;
    }
} 