<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

interface AccountInterface
{
    public function onCreate();
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $domain
     * @return AccountInterface
     */
    public function setDomain($domain);

    /**
     * @return string
     */
    public function getDomain();

    /**
     * @param string $companyName
     * @return AccountInterface
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param GroupInterface[] $groups
     * @return AccountInterface
     */
    public function setGroups($groups);

    /**
     * @return ArrayCollection
     */
    public function getGroups();

    /**
     * @param GroupInterface[] $contacts
     * @return AccountInterface
     */
    public function setContacts($contacts);

    /**
     * @return ArrayCollection
     */
    public function getContacts();
} 