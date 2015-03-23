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
     * @param \DateTime $deadLine
     * @return TaskInterface
     */
    public function setDeadLine(\DateTime $deadLine);

    /**
     * @return \DateTime
     */
    public function getDeadLine();

    /**
     * @param \DateTime $rememberAt
     * @return TaskInterface
     */
    public function setRememberAt(\DateTime $rememberAt);

    /**
     * @return \DateTime
     */
    public function getRememberAt();

    /**
     * @param UserInterface $user
     * @return TaskInterface
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

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
     * @param ActivityInterface[] $activities
     * @return TaskInterface
     */
    public function setActivities($activities);

    /**
     * @return ActivityInterface[]
     */
    public function getActivities();
}