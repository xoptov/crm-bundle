<?php

namespace Perfico\CRMBundle\Entity;

interface TaskInterface
{
    public function onCreate();
    public function onUpdate();

    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $name
     * @return TaskInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $note
     * @return TaskInterface
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param dateTime $deadLine
     * @return TaskInterface
     */
    public function setDeadLine($deadLine)
    {
        $this->deadLine = $deadLine;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeadLine()
    {
        return $this->deadLine;
    }

    /**
     * @param dateTime $rememberAt
     * @return TaskInterface
     */
    public function setRememberAt($rememberAt)
    {
        $this->rememberAt = $rememberAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRememberAt()
    {
        return $this->rememberAt;
    }

    /**
     * @param UserInterface $assignie
     * @return TaskInterface
     */
    public function setAssignie(UserInterface $assignie)
    {
        $this->assignie = $assignie;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getAssignie()
    {
        return $this->assignie;
    }

    /**
     * @param TaskStateInterface $taskState
     * @return TaskInterface
     */
    public function setState(TaskStateInterface $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return TaskStateInterface
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param AccountInterface $account
     * @return ClientInterface
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

    /**
     * @param ActivityInterface $activities
     * @return TaskInterface
     */
    public function setActivities(ActivityInterface $activities)
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * @return ActivityInterface
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * @param SubTaskInterface $subTask
     * @return TaskInterface
     */
    public function setSubTask(SubTaskInterface $subTask)
    {
        $this->subTask= $subTask;

        return $this;
    }

    /**
     * @return SubTaskInterface
     */
    public function getSubTask()
    {
        return $this->subTask;
    }
}