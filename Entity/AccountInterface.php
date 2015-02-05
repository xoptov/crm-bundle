<?php

namespace Perfico\DosalesBundle\Entity;

interface AccountInterface
{
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

} 