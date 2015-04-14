<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

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

    /** @var ArrayCollection */
    protected $groups;

    /** @var ArrayCollection */
    protected $contacts;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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
    public function setGroups($groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts()
    {
        return $this->contacts;
    }
} 