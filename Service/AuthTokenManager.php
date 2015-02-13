<?php

namespace Perfico\CRMBundle\Service;

use Perfico\CRMBundle\Entity\UserInterface;
use Perfico\CRMBundle\Entity\AuthToken;

class AuthTokenManager
{
    /**
     * @param UserInterface $user
     * @param string $expirationTime
     * @return AuthToken
     */
    public function generate(UserInterface $user, $expirationTime = AuthToken::EXPIRATION_TIME)
    {
        $token = sha1(uniqid(mt_rand(), true));
        $expireAt = new \DateTime('+ ' . $expirationTime);

        $authToken = new AuthToken();
        $authToken->setUser($user);
        $authToken->setToken($token);
        $authToken->setExpireAt($expireAt);

        return $authToken;
    }
} 