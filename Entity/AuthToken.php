<?php

namespace Perfico\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class AuthToken
{
    const EXPIRATION_TIME = '1 hour';

    /** @var integer */
    private $id;

    /** @var User */
    private $user;

    /** @var string */
    private $token;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $expireAt;

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * @param \DateTime $expireAt
     */
    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;
    }
}