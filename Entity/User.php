<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

abstract class User extends BaseUser implements UserInterface
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $middleName;

    /** @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html */
    protected $contacts;

    /** @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html */
    protected $deals;

    /** @var string */
    protected $photo;

    public function __construct()
    {
        parent::__construct();
        $this->contacts = new ArrayCollection();
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
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMiddleName()
    {
        return $this->middleName;
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
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoto()
    {
        return $this->photo;
    }
} 