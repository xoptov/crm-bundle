<?php


namespace Perfico\CRMBundle\Security\Authentication\Provider;

use Doctrine\ORM\EntityManager;
use Perfico\UserBundle\Entity\User;

class UserProvider
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $token
     * @return User
     */
    public function findUserByToken($token)
    {
        $authToken = $this->entityManager->getRepository('CRMBundle:AuthToken')->getNotExpired($token);

        if ($authToken) {
            return $authToken->getUser();
        }

        return null;
    }

}

