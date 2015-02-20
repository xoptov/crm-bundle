<?php

namespace Perfico\CRMBundle\Entity;

interface ActivityInterface
{
    const TYPE_CALL = 'call';
    const TYPE_EMAIL = 'email';
    const TYPE_MESSAGE = 'message';
    const TYPE_MEETING = 'meeting';

    public function onCreate();

    public function onUpdate();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $type
     * @return ActivityInterface
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getType();

    /**
     * @return array
     */
    public static function getTypes();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime $datetime
     * @return ActivityInterface
     */
    public function setRememberAt(\DateTime $datetime);

    /**
     * @return \DateTime
     */
    public function getRememberAt();

    /**
     * @param string $note
     * @return ActivityInterface
     */
    public function setNote($note);

    /**
     * @return string
     */
    public function getNote();

    /**
     * @param UserInterface $user
     * @return ActivityInterface
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param ClientInterface $client
     * @return ActivityInterface
     */
    public function setClient(ClientInterface $client);

    /**
     * @return ClientInterface
     */
    public function getClient();

    /**
     * @param AccountInterface $account
     * @return ActivityInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 