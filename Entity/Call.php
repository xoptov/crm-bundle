<?php

namespace Perfico\CRMBundle\Entity;

use Perfico\SipuniBundle\Entity\Call as BaseCall;
use Doctrine\Common\Collections\ArrayCollection;

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
} 