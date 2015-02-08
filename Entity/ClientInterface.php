<?php

namespace Perfico\CRMBundle\Entity;

interface ClientInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $firstName
     * @return ClientInterface
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $lastName
     * @return ClientInterface
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $middleName
     * @return mixed
     */
    public function setMiddleName($middleName);

    /**
     * @return string
     */
    public function getMiddleName();

    /**
     * @param string $note
     * @return ClientInterface
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
     * @param UserInterface $user
     * @return ClientInterface
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param ChannelInterface $channel
     * @return ClientInterface
     */
    public function setChannel(ChannelInterface $channel);

    /**
     * @return ChannelInterface
     */
    public function getChannel();

    /**
     * @param CompanyInterface $company
     * @return ClientInterface
     */
    public function setCompany(CompanyInterface $company);

    /**
     * @return CompanyInterface
     */
    public function getCompany();

    /**
     * @param DealInterface[] $deals
     * @return ClientInterface
     */
    public function setDeals($deals);

    /**
     * @return ClientInterface
     */
    public function getDeals();

    /**
     * @param PhoneInterface[] $phones
     * @return ClientInterface
     */
    public function setPhones($phones);

    /**
     * @return PhoneInterface[]
     */
    public function getPhones();

    /**
     * @param string $mail
     * @return ClientInterface
     */
    public function setEmail($mail);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param ActivityInterface[] $activities
     * @return ClientInterface
     */
    public function setActivities($activities);

    /**
     * @return ActivityInterface[]
     */
    public function getActivities();

    /**
     * @param AccountInterface $account
     * @return ClientInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 