<?php

namespace Perfico\CRMBundle\Security\Authentication\Provider;

use Perfico\CRMBundle\Security\Authentication\Token\ApiToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiProvider implements AuthenticationProviderInterface
{
    /**
     * @var
     */
    private $providerId;

    /**
     * @var
     */
    private $key;

    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var UserChecker
     */
    private $userChecker;

    /**
     * @param UserProviderInterface $userProvider
     * @param $providerId
     * @param $key
     * @param UserChecker $userChecker
     */
    public function __construct(UserProviderInterface $userProvider, $providerId, $key, UserChecker $userChecker)
    {
        $this->providerId = $providerId;
        $this->key = $key;
        $this->userProvider = $userProvider;
        $this->userChecker = $userChecker;
    }

    /**
     * Attempts to authenticate a TokenInterface object.
     *
     * @param TokenInterface $token The TokenInterface instance to authenticate
     *
     * @return TokenInterface An authenticated TokenInterface instance, never null
     *
     * @throws AuthenticationException if the authentication fails
     */
    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return null;
        }

        $user = $token->getUser();

        /** @var ApiToken $token */
        if ($this->key !== $token->getKey()) {
            throw new BadCredentialsException('The presented key does not match.');
        }

        $this->userChecker->checkPostAuth($user);

        $authenticatedToken = new ApiToken($user->getRoles(), $this->providerId, $this->key);
        $authenticatedToken->setUser($user);
        $authenticatedToken->setAttributes($token->getAttributes());
        $authenticatedToken->setAuthenticated(true);

        return $authenticatedToken;
    }

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return bool    true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        return ($token instanceof ApiToken);
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }
} 