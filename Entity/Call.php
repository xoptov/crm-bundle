<?php

namespace Perfico\CRMBundle\Entity;

use Perfico\SipuniBundle\Entity\AnswerEvent;
use Perfico\SipuniBundle\Entity\Call as BaseCall;
use Doctrine\Common\Collections\ArrayCollection;
use Perfico\SipuniBundle\Entity\HangupEventInterface;

abstract class Call extends BaseCall implements CallInterface
{
    /** @var AccountInterface */
    protected $account;

    /** @var ActivityInterface */
    protected $activity;

    /** @var string */
    protected $direction;

    /** @var ArrayCollection */
    protected $calledUsers;

    /** @var integer */
    protected $duration;

    public function __construct()
    {
        parent::__construct();
        $this->calledUsers = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function setAccount(AccountInterface $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivity(ActivityInterface $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * {@inheritdoc}
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDirection()
    {
        return $this->direction;
    }


    /**
     * {@inheritdoc}
     */
    public function addCallee(UserInterface $user)
    {
        $this->calledUsers->add($user);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCalledUsers()
    {
        return $this->calledUsers;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastCallee()
    {
        return $this->calledUsers->last();
    }

    /**
     * {@inheritdoc}
     */
    public function setDuration($seconds)
    {
        $this->duration = $seconds;
    }

    /**
     * {@inheritdoc}
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->activity->setUser($user);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        if ($this->activity instanceof ActivityInterface) {
            return $this->activity->getUser();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setClient(ClientInterface $client)
    {
        $this->activity->setClient($client);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        if ($this->activity instanceof ActivityInterface) {
            return $this->activity->getClient();
        }

        return null;
    }

    public function getStartTalk()
    {
        if ($this->answerEvent instanceof AnswerEvent) {
            return $this->answerEvent->getEventDate();
        }
        
        return null;
    }

    public function getEndTalk()
    {
        if ($this->hangupEvent instanceof HangupEventInterface) {
            return $this->hangupEvent->getEventDate();
        }

        return null;
    }
} 