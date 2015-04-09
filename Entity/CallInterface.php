<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

interface CallInterface
{
    const DIRECTION_OUTBOUND = 'outbound';
    const DIRECTION_INCOMING = 'incoming';

    /**
     * @param AccountInterface $account
     * @return CallInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();

    /**
     * @param ActivityInterface $activity
     * @return CallInterface
     */
    public function setActivity(ActivityInterface $activity);

    /**
     * @return ActivityInterface
     */
    public function getActivity();

    /**
     * @param string $direction
     * @return CallInterface
     */
    public function setDirection($direction);

    /**
     * @return string
     */
    public function getDirection();

    /**
     * @param UserInterface $user
     * @return CallInterface
     */
    public function addCallee(UserInterface $user);

    /**
     * @return ArrayCollection
     */
    public function getCalledUsers();

    /**
     * @return UserInterface|null
     */
    public function getLastCallee();
} 