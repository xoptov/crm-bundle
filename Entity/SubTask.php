<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

abstract class SubTask implements TaskStateInterface
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $note;

    /** @var integer */
    protected $completed;

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
}