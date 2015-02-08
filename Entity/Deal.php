<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Deal implements DealInterface
{
    /** @var integer */
    protected $id;

    /** @var float */
    protected $amount;

    /** @var \DateTime */
    protected $createdAt;

    /** @var string */
    protected $note;

    /** @var ClientInterface */
    protected $client;

    /** @var DealStateInterface */
    protected $state;

    /**
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     * @var PaymentInterface[]
     */
    protected $payments;

    /** @var UserInterface */
    protected $user;

    /** @var AccountInterface */
    protected $account;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * {@inheritdoc}
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(DealStateInterface $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
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
} 