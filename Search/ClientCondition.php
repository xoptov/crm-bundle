<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Entity\AccountInterface;

final class ClientCondition implements ClientConditionInterface
{
    /** @var string */
    private $name;

    /** @var integer */
    private $user;

    /** @var string */
    private $email;

    /** @var bool */
    private $emailNotSpecified;

    /** @var string */
    private $phone;

    /** @var bool */
    private $phoneNotSpecified;

    /** @var integer */
    private $channel;

    /** @var integer */
    private $company;

    /** @var \DateTime */
    private $createdFrom;

    /** @var \DateTime */
    private $createdTo;

    /** @var \DateTime */
    private $dealFrom;

    /** @var \DateTime */
    private $dealTo;

    /** @var \DateTime */
    private $activityFrom;

    /** @var \DateTime */
    private $activityTo;

    /** @var array */
    private $dealStates;

    /** @var array */
    private $tags;

    /** @var bool */
    private $delayedPayment;

    /** @var integer */
    private $offset;

    /** @var integer */
    private $limit;

    /** @var AccountInterface */
    private $account;

    public function __construct()
    {
        $this->emailNotSpecified = false;
        $this->phoneNotSpecified = false;
    }

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
     * {@inheritdoc}
     */
    public function setEmailNotSpecified($value)
    {
        $this->emailNotSpecified = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailNotSpecified()
    {
        return $this->emailNotSpecified;
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
     * {@inheritdoc}
     */
    public function setPhoneNotSpecified($value)
    {
        $this->phoneNotSpecified = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoneNotSpecified()
    {
        return $this->phoneNotSpecified;
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
     * @param integer $company
     * @return ClientCondition
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return int
     */
    public function getCompany()
    {
        return $this->company;
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