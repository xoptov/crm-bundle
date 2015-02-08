<?php

namespace Perfico\CRMBundle\Entity\PBX\Sipuni;


interface HangupEventInterface extends CallEventInterface
{
    /**
     * @param string $status
     * @return HangupEventInterface
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param \DateTime $date
     * @return HangupEventInterface
     */
    public function setStartDate(\DateTime $date);

    /**
     * @return \DateTime
     */
    public function getStartDate();

    /**
     * @param \DateTime $date
     * @return HangupEventInterface
     */
    public function setAnswerDate(\DateTime $date);

    /**
     * @return \DateTime
     */
    public function getAnswerDate();

    /**
     * @param string $link
     * @return HangupEventInterface
     */
    public function setRecordLink($link);

    /**
     * @return string
     */
    public function getRecordLink();
} 