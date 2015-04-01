<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

abstract class DealState implements DealStateInterface
{
    /** @var integer */
    protected $id;

    /** @var DealStateInterface */
    protected $acceptor;

    /** @var string */
    protected $name;

    /** @var string */
    protected $icon;

    /**
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     * @var DealInterface[]
     */
    protected $deals;

    /** @var AccountInterface */
    protected $account;

    /** @var boolean */
    protected $requirePayments;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
        $this->requirePayments = false;
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
    public function setAcceptor(DealStateInterface $acceptor)
    {
        $this->acceptor = $acceptor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAcceptor()
    {
        return $this->acceptor;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeals($deals)
    {
        $this->deals = $deals;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeals()
    {
        return $this->deals;
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
    public function setRequirePayments($value)
    {
        $this->requirePayments = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequirePayments()
    {
        return $this->requirePayments;
    }
} 