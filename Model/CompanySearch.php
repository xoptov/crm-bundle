<?php

namespace Perfico\CRMBundle\Model;

class CompanySearch
{
    /** @var string */
    protected $name;

    /** @var array */
    protected $tags;

    /** @var array */
    protected $dealStates;

    /** @var \DateTime */
    protected $dealFrom;

    /** @var \DateTime */
    protected $dealTo;

    /** @var \DateTime */
    protected $activityFrom;

    /** @var \DateTime */
    protected $activityTo;

    /** @var bool */
    protected $delayedPayment;

    /**
     * @param $name
     * @return CompanySearch
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
     * @param array $tags
     * @return CompanySearch
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
     * @param array $dealStates
     * @return CompanySearch
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
     * @param \DateTime $datetime
     * @return CompanySearch
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
     * @return CompanySearch
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
     * @return CompanySearch
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
     * @return CompanySearch
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
} 