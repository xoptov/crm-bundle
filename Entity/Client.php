<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Client implements ClientInterface
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
    protected $note;

    /** @var \DateTime */
    protected $createdAt;

    /** @var UserInterface */
    protected $user;

    /** @var ChannelInterface */
    protected $channel;

    /** @var CompanyInterface */
    protected $company;

    /**
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     * @var DealInterface[]
     */
    protected $deals;

    /**
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     * @var PhoneInterface[]
     */
    protected $phones;

    /**
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/inheritance-mapping.html#association-override
     * @var ActivityInterface[]
     */
    protected $activities;

    /** @var string */
    protected $email;

    /** @var AccountInterface */
    protected $account;

    /** @var string */
    protected $customField1;

    /** @var string */
    protected $customField2;

    /** @var string */
    protected $customField3;

    /** @var string */
    protected $customField4;

    /** @var string */
    protected $customField5;

    /** @var string */
    protected $customField6;

    /** @var string */
    protected $customField7;

    /** @var string */
    protected $customField8;

    /** @var string */
    protected $customField9;

    /** @var string */
    protected $customField10;

    /** @var string */
    protected $customField11;

    /** @var string */
    protected $customField12;

    /** @var string */
    protected $customField13;

    /** @var string */
    protected $customField14;

    /** @var string */
    protected $customField15;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function __construct()
    {
        $this->deals = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->activities = new ArrayCollection();
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
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNote()
    {
        return $this->note;
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
    public function setUser(UserInterface $user = null)
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
    public function setChannel(ChannelInterface $channel = null)
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
     * {@inheritdoc}
     */
    public function setCompany(CompanyInterface $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompany()
    {
        return $this->company;
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
    public function setPhones($phones)
    {
        $this->phones = $phones;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function setCustomField1($customField1)
    {
        $this->customField1 = $customField1;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField1()
    {
        return $this->customField1;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField2($customField2)
    {
        $this->customField2 = $customField2;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField2()
    {
        return $this->customField2;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField3($customField3)
    {
        $this->customField3 = $customField3;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField3()
    {
        return $this->customField3;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField4($customField4)
    {
        $this->customField4 = $customField4;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField4()
    {
        return $this->customField4;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField5($customField5)
    {
        $this->customField5 = $customField5;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField5()
    {
        return $this->customField5;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField6($customField6)
    {
        $this->customField6 = $customField6;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField6()
    {
        return $this->customField6;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField7($customField7)
    {
        $this->customField7 = $customField7;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField7()
    {
        return $this->customField7;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField8($customField8)
    {
        $this->customField8 = $customField8;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField8()
    {
        return $this->customField8;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField9($customField9)
    {
        $this->customField9 = $customField9;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField9()
    {
        return $this->customField9;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField10($customField10)
    {
        $this->customField10 = $customField10;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField10()
    {
        return $this->customField10;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField11($customField11)
    {
        $this->customField11 = $customField11;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField11()
    {
        return $this->customField11;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField12($customField12)
    {
        $this->customField12 = $customField12;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField12()
    {
        return $this->customField12;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField13($customField13)
    {
        $this->customField13 = $customField13;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField13()
    {
        return $this->customField13;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField14($customField14)
    {
        $this->customField14 = $customField14;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField14()
    {
        return $this->customField14;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomField15($customField15)
    {
        $this->customField15 = $customField15;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomField15()
    {
        return $this->customField15;
    }
}
