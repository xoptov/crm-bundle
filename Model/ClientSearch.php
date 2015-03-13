<?php

namespace Perfico\CRMBundle\Model;

use Perfico\CRMBundle\Entity\AccountInterface;

class ClientSearch
{
    /** @var string */
    protected $name;

    /** @var integer */
    protected $user;

    /** @var string */
    protected $email;

    /** @var string */
    protected $phone;

    /** @var integer */
    protected $channel;

    /** @var \DateTime */
    protected $createdFrom;

    /** @var \DateTime */
    protected $createdTo;

    /** @var \DateTime */
    protected $dealFrom;

    /** @var \DateTime */
    protected $dealTo;

    /** @var \DateTime */
    protected $activityFrom;

    /** @var \DateTime */
    protected $activityTo;

    /** @var array */
    protected $dealStates;

    /** @var array */
    protected $tags;

    /** @var bool */
    protected $delayedPayment;

    /** @var integer */
    protected $offset;

    /** @var integer */
    protected $limit;

    /** @var AccountInterface */
    protected $account;

    /**
     * @param $name
     * @return ClientSearch
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param integer $user
     * @return ClientSearch
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $email
     * @return ClientSearch
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $phone
     * @return ClientSearch
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param integer $channel
     * @return ClientSearch
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return integer
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientSearch
     */
    public function setCreatedFrom($datetime)
    {
        $this->createdFrom = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedFrom()
    {
        return $this->createdFrom;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientSearch
     */
    public function setCreatedTo($datetime)
    {
        $this->createdTo = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTo()
    {
        return $this->createdTo;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientSearch
     */
    public function setDealFrom(\DateTime $datetime)
    {
        $this->dealFrom = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDealFrom()
    {
        return $this->dealFrom;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientSearch
     */
    public function setDealTo(\DateTime $datetime)
    {
        $this->dealTo = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDealTo()
    {
        return $this->dealTo;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientSearch
     */
    public function setActivityFrom(\DateTime $datetime)
    {
        $this->activityFrom = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getActivityFrom()
    {
        return $this->activityFrom;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientSearch
     */
    public function setActivityTo(\DateTime $datetime)
    {
        $this->activityTo = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getActivityTo()
    {
        return $this->activityTo;
    }

    /**
     * @param array $dealStates
     * @return ClientSearch
     */
    public function setDealStates($dealStates)
    {
        $this->dealStates = $dealStates;

        return $this;
    }

    /**
     * @return array
     */
    public function getDealStates()
    {
        return $this->dealStates;
    }

    /**
     * @param array $tags
     * @return ClientSearch
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param bool $delayedPayment
     * @return ClientSearch
     */
    public function setDelayedPayment($delayedPayment)
    {
        $this->delayedPayment = $delayedPayment;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDelayedPayment()
    {
        return $this->delayedPayment;
    }

    /**
     * @param integer $offset
     * @return ClientSearch
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param integer $limit
     * @return ClientSearch
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param AccountInterface $account
     * @return ClientSearch
     */
    public function setAccount(AccountInterface $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return AccountInterface
     */
    public function getAccount()
    {
        return $this->account;
    }
} 