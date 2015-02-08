<?php

namespace Perfico\CRMBundle\Entity;

abstract class Activity implements ActivityInterface
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $type;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $updatedAt;

    /** @var \DateTime */
    protected $rememberAt;

    /** @var string */
    protected $note;

    /** @var UserInterface */
    protected $user;

    /** @var ClientInterface */
    protected $client;

    /** @var AccountInterface */
    protected $account;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public static function getTypes()
    {
        return array(
            ActivityInterface::TYPE_CALL => 'activity.type.call',
            ActivityInterface::TYPE_EMAIL => 'activity.type.email',
            ActivityInterface::TYPE_MESSAGE => 'activity.type.message',
            ActivityInterface::TYPE_MEETING => 'activity.type.meeting'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setRememberAt(\DateTime $datetime)
    {
        $this->rememberAt = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberAt()
    {
        return $this->rememberAt;
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
    public function getId()
    {
        return $this->id;
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
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        return $this->client;
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