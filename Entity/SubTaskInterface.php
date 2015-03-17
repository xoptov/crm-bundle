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
     * @param $completed
     * @return SubTaskInterface
     */
    public function setCompleted($completed);

    /**
     * @return integer
     */
    public function getCompleted();
}