<?php

namespace Perfico\CRMBundle\Entity;

abstract class Task implements TaskInterface
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $note;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $updatedAt;

    /** @var \DateTime */
    protected $deadLine;

    /** @var \DateTime */
    protected $rememberAt;

    /** @var UserInterface */
    protected $assignie;

    /** @var TaskStateInterface */
    protected $state;

    /** @var AccountInterface */
    protected $account;

    /** @var ActivityInterface */
    protected $activities;

    /** @var SubTaskInterface */
    protected $subTask;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeadLine($deadLine)
    {
        $this->deadLine = $deadLine;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeadLine()
    {
        return $this->deadLine;
    }

    /**
     * {@inheritdoc}
     */
    public function setRememberAt($rememberAt)
    {
        $this->rememberAt = $rememberAt;

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
    public function setAssignie(UserInterface $assignie)
    {
        $this->assignie = $assignie;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAssignie()
    {
        return $this->assignie;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(TaskStateInterface $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
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
    public function setActivities(ActivityInterface $activities)
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
    public function setSubTask(SubTaskInterface $subTask)
    {
        $this->subTask= $subTask;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTask()
    {
        return $this->subTask;
    }
}
