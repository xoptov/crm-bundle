<?php

namespace Perfico\CRMBundle\Entity;

abstract class SubTask implements SubTaskInterface
{
    /** @var integer */
    protected $id;

    /** @var TaskInterface */
    protected $task;

    /** @var string */
    protected $note;

    /** @var integer */
    protected $completed;

    /** @var AccountInterface */
    protected $account;

    public function __construct()
    {
        $this->completed = false;
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
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTask()
    {
        return $this->task;
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
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompleted()
    {
        return $this->completed;
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