<?php

namespace Perfico\CRMBundle\Entity;

interface TaskTypeInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $name
     * @return TaskTypeInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $icon
     * @return TaskTypeInterface
     */
    public function setIcon($icon);

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @param TaskInterface $tasks
     * @return TaskType
     */
    public function setTasks($tasks);

    /**
     * @return TaskInterface
     */
    public function getTasks();

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