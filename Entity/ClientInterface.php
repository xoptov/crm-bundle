<?php

namespace Perfico\CRMBundle\Entity;

interface ClientInterface
{
    public function onCreate();

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
     * @param string $position
     * @return ClientInterface
     */
    public function setPosition($position);

    /**
     * @return string
     */
    public function getPosition();

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

    /**
     * @param string $customField1
     * @return ClientInterface
     */
    public function setCustomField1($customField1);

    /**
     * @return string
     */
    public function getCustomField1();

    /**
     * @param string $customField2
     * @return ClientInterface
     */
    public function setCustomField2($customField2);

    /**
     * @return string
     */
    public function getCustomField2();

    /**
     * @param string $customField3
     * @return ClientInterface
     */
    public function setCustomField3($customField3);

    /**
     * @return string
     */
    public function getCustomField3();

    /**
     * @param string $customField4
     * @return ClientInterface
     */
    public function setCustomField4($customField4);

    /**
     * @return string
     */
    public function getCustomField4();

    /**
     * @param string $customField5
     * @return ClientInterface
     */
    public function setCustomField5($customField5);

    /**
     * @return string
     */
    public function getCustomField5();

    /**
     * @param string $customField6
     * @return ClientInterface
     */
    public function setCustomField6($customField6);

    /**
     * @return string
     */
    public function getCustomField6();

    /**
     * @param string $customField7
     * @return ClientInterface
     */
    public function setCustomField7($customField7);

    /**
     * @return string
     */
    public function getCustomField7();

    /**
     * @param string $customField8
     * @return ClientInterface
     */
    public function setCustomField8($customField8);

    /**
     * @return string
     */
    public function getCustomField8();

    /**
     * @param string $customField9
     * @return ClientInterface
     */
    public function setCustomField9($customField9);

    /**
     * @return string
     */
    public function getCustomField9();

    /**
     * @param string $customField10
     * @return ClientInterface
     */
    public function setCustomField10($customField10);

    /**
     * @return string
     */
    public function getCustomField10();

    /**
     * @param string $customField11
     * @return ClientInterface
     */
    public function setCustomField11($customField11);

    /**
     * @return string
     */
    public function getCustomField11();

    /**
     * @param string $customField12
     * @return ClientInterface
     */
    public function setCustomField12($customField12);

    /**
     * @return string
     */
    public function getCustomField12();

    /**
     * @param string $customField13
     * @return ClientInterface
     */
    public function setCustomField13($customField13);

    /**
     * @return string
     */
    public function getCustomField13();

    /**
     * @param string $customField14
     * @return ClientInterface
     */
    public function setCustomField14($customField14);

    /**
     * @return string
     */
    public function getCustomField14();

    /**
     * @param string $customField15
     * @return ClientInterface
     */
    public function setCustomField15($customField15);

    /**
     * @return string
     */
    public function getCustomField15();
} 