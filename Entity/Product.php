<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Product implements ProductInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $updatedAt;

    /** @var float */
    protected $amount;

    /** @var AccountInterface */
    protected $account;

    /**
     * @var ProductInterface[]
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     */
    protected $children;

    /** @var ProductInterface */
    protected $parent;

    /** @var string */
    protected $sku;

    /**
     * @var DealInterface[]
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     */
    protected $deals;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->deals = new ArrayCollection();
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
    public function getChildren()
    {
        return $this->children;
    }

    public function hasChildren()
    {
        return !$this->children->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(ProductInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeals()
    {
        return $this->deals;
    }
} 