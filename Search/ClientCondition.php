<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Entity\AccountInterface;

class ClientCondition implements ClientConditionInterface
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
     * @return ClientCondition
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
     * @param integer $user
     * @return ClientCondition
     */
    public function setUser($user)
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
     * @param string $email
     * @return ClientCondition
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $phone
     * @return ClientCondition
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
     * @param integer $channel
     * @return ClientCondition
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientCondition
     */
    public function setCreatedFrom($datetime)
    {
        $this->createdFrom = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedFrom()
    {
        return $this->createdFrom;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientCondition
     */
    public function setCreatedTo($datetime)
    {
        $this->createdTo = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedTo()
    {
        return $this->createdTo;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientCondition
     */
    public function setDealFrom(\DateTime $datetime)
    {
        $this->dealFrom = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDealFrom()
    {
        return $this->dealFrom;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientCondition
     */
    public function setDealTo(\DateTime $datetime)
    {
        $this->dealTo = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDealTo()
    {
        return $this->dealTo;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientCondition
     */
    public function setActivityFrom(\DateTime $datetime)
    {
        $this->activityFrom = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityFrom()
    {
        return $this->activityFrom;
    }

    /**
     * @param \DateTime $datetime
     * @return ClientCondition
     */
    public function setActivityTo(\DateTime $datetime)
    {
        $this->activityTo = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityTo()
    {
        return $this->activityTo;
    }

    /**
     * @param array $dealStates
     * @return ClientCondition
     */
    public function setDealStates($dealStates)
    {
        $this->dealStates = $dealStates;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDealStates()
    {
        return $this->dealStates;
    }

    /**
     * @param array $tags
     * @return ClientCondition
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param bool $delayedPayment
     * @return ClientCondition
     */
    public function setDelayedPayment($delayedPayment)
    {
        $this->delayedPayment = $delayedPayment;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDelayedPayment()
    {
        return $this->delayedPayment;
    }

    /**
     * @param integer $offset
     * @return ClientCondition
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param integer $limit
     * @return ClientCondition
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param AccountInterface $account
     * @return ClientCondition
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