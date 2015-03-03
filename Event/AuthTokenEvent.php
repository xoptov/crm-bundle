<?php

namespace Perfico\CRMBundle\Event;

use Perfico\CRMBundle\Entity\AuthToken;
use Symfony\Component\EventDispatcher\Event;

class AuthTokenEvent extends Event
{
    protected $username;

    protected $password;

    /** @var AuthToken */
    protected $token;

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setToken(AuthToken $token)
    {
        $this->token = $token;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }
} 