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

    /** @var string */
    protected $phone;

    /**
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     * @var DealInterface[]
     */
    protected $deals;

    /**
     * @var AccountInterface
     * @deprecated please using accounts instead this field
     */
    protected $account;

    /** @var AccountInterface[] */
    protected $accounts;

    /** @var string */
    protected $photo;

    public function __construct()
    {
        parent::__construct();
        $this->deals = new ArrayCollection();
        $this->accounts = new ArrayCollection();
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
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->phone;
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
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * {@inheritdoc}
     */
    public function addAccount(AccountInterface $account)
    {
        $this->accounts->add($account);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAccount(AccountInterface $account)
    {
        $this->accounts->removeElement($account);

        return $this;
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