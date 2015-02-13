<?php

namespace Perfico\CRMBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\Role\RoleInterface;

class ApiToken extends AbstractToken
{
    /** @var array|RoleInterface[] */
    private $providerId;

    /** @var */
    private $key;

    /**
     * @param array|RoleInterface[] $roles
     * @param string $providerId
     * @param string $key
     */
    public function __construct($roles, $providerId, $key)
    {
        $this->providerId = $providerId;
        $this->key = $key;

        parent::__construct($roles);
    }

    /**
     * Returns the user credentials.
     *
     * @return mixed The user credentials
     */
    public function getCredentials()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
                $this->key,
                $this->providerId,
                parent::serialize(),
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->key, $this->providerId, $parentStr) = unserialize($serialized);
        parent::unserialize($parentStr);
    }

    /**
     * @return array|RoleInterface[]
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @param array|RoleInterface[] $providerId
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
} 