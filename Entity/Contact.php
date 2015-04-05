<?php

namespace Perfico\CRMBundle\Entity;

abstract class Contact implements ContactInterface
{
    /** @var integer */
    protected $id;

    /** @var UserInterface */
    protected $user;

    /** @var string */
    protected $phone;

    /** @var string */
    protected $sip;

    /** @var string */
    protected $skype;

    /** @var AccountInterface */
    protected $account;

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
    public function setSip($sip)
    {
        $this->sip = $sip;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSip()
    {
        return $this->sip;
    }

    /**
     * {@inheritdoc}
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSkype()
    {
        return $this->skype;
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