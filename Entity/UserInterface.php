<?php

namespace Perfico\CRMBundle\Entity;

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;
use FOS\UserBundle\Model\GroupInterface as BaseGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface UserInterface extends BaseUserInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $firstName
     * @return UserInterface
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $lastName
     * @return UserInterface
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $middleName
     * @return UserInterface
     */
    public function setMiddleName($middleName);

    /**
     * @return string
     */
    public function getMiddleName();

    /**
     * @param string $phone
     * @return UserInterface
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param DealInterface[] $deals
     * @return mixed
     */
    public function setDeals($deals);

    /**
     * @return DealInterface[]
     */
    public function getDeals();

    /**
     * @param ArrayCollection $groups
     * @return UserInterface
     */
    public function setGroups($groups);

    /**
     * @return ArrayCollection
     */
    public function getGroups();

    /**
     * @param BaseGroupInterface $group
     * @return UserInterface
     */
    public function addGroup(BaseGroupInterface $group);

    /**
     * @param BaseGroupInterface $group
     * @return UserInterface
     */
    public function removeGroup(BaseGroupInterface $group);

    /**
     * @param string $photo
     * @return UserInterface
     */
    public function setPhoto($photo);

    /**
     * @return string
     */
    public function getPhoto();
} 