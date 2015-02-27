<?php

namespace Perfico\CRMBundle\Entity;

abstract class Account implements AccountInterface
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $domain;

    /** @var string */
    protected $companyName;

    /** @var \DateTime */
    protected $createdAt;

    /** @var boolean */
    protected $fake;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function __construct()
    {
        $this->fake = false;
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
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyName()
    {
        return $this->companyName;
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
    public function setFake($value)
    {
        $this->fake = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function isFake()
    {
        return $this->fake;
    }
} 