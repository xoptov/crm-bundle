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
    public function setNote($note);

    /**
     * @return string
     */
    public function getNote();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param dateTime $deadLine
     * @return TaskInterface
     */
    public function setDeadLine($deadLine);

    /**
     * @return \DateTime
     */
    public function getDeadLine();

    /**
     * @param dateTime $rememberAt
     * @return TaskInterface
     */
    public function setRememberAt($rememberAt);

    /**
     * @return \DateTime
     */
    public function getRememberAt();

    /**
     * @param UserInterface $assignie
     * @return TaskInterface
     */
    public function setAssignie(UserInterface $assignie);

    /**
     * @return UserInterface
     */
    public function getAssignie();

    /**
     * @param TaskStateInterface $state
     * @return TaskInterface
     */
    public function setState(TaskStateInterface $state);

    /**
     * @return TaskStateInterface
     */
    public function getState();

    /**
     * @param AccountInterface $account
     * @return ClientInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();

    /**
     * @param ActivityInterface $activities
     * @return TaskInterface
     */
    public function setActivities(ActivityInterface $activities);

    /**
     * @return ActivityInterface
     */
    public function getActivities();

    /**
     * @param SubTaskInterface $subTask
     * @return TaskInterface
     */
    public function setSubTask(SubTaskInterface $subTask);

    /**
     * @return SubTaskInterface
     */
    public function getSubTask();
}