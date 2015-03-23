<?php

namespace Perfico\CRMBundle\Entity;

interface SubTaskInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $note
     * @return SubTaskInterface
     */
    public function setNote($note);

    /**
     * @return string
     */
    public function getNote();

    /**
     * @param TaskInterface $task
     * @return SubTaskInterface
     */
    public function setTask($task);

    /**
     * @return integer
     */
    public function getTask();

    /**
     * @param $completed
     * @return SubTaskInterface
     */
    public function setCompleted($completed);

    /**
     * @return integer
     */
    public function getCompleted();

    /**
     * @param $account
     * @return TaskStateInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
}