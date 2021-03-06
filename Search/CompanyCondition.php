<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Entity\AccountInterface;

final class CompanyCondition implements CompanyConditionInterface
{
    /** @var string */
    private $name;

    /** @var array */
    private $tags;

    /** @var array */
    private $dealStates;

    /** @var \DateTime */
    private $dealFrom;

    /** @var \DateTime */
    private $dealTo;

    /** @var \DateTime */
    private $activityFrom;

    /** @var \DateTime */
    private $activityTo;

    /** @var bool */
    private $delayedPayment;

    /** @var integer */
    private $offset;

    /** @var integer */
    private $limit;

    /** @var AccountInterface */
    private $account;

    /**
     * @param $name
     * @return CompanyCondition
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
     * @param array $tags
     * @return CompanyCondition
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
     * @param array $dealStates
     * @return CompanyCondition
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
     * @param \DateTime $datetime
     * @return CompanyCondition
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
     * @return CompanyCondition
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
     * @return CompanyCondition
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
     * @return CompanyCondition
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
     * @param $delayedPayment
     * @return $this
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
     * @return CompanyCondition
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
     * @return CompanyCondition
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
     */
    public function setAccount(AccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccount()
    {
        return $this->account;
    }
} 