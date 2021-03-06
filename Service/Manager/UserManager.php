<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\UserBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\QueryBuilder;

class UserManager extends GenericManager
{
    /** @var UserManagerInterface */
    protected $userManager;

    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return integer
     */
    public function getCountAccountUsers()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('UserBundle:User');

        return $repo->createQueryBuilder('u')
            ->select('count(u)')
            ->leftJoin('u.groups', 'g')
            ->where('g.account = :account')
            ->setParameter('account', $this->getCurrentAccount())
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param integer $page
     * @param integer $limit
     * @return User[]
     * @todo need refactoring this method
     */
    public function getAccountUsers($page, $limit)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('UserBundle:User');

        return $repo->createQueryBuilder('u')
            ->leftJoin('u.groups', 'g')
            ->where('g.account = :account')
            ->setParameter('account', $this->getCurrentAccount())
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function create()
    {
        /** @var User $user */
        $user = $this->userManager->createUser();
        $user->setPlainPassword(md5(rand(1000000, 9999999), false));

        $user->setEnabled(true);

        return $user;
    }

    public function update($entity)
    {
        $this->userManager->updateUser($entity);
    }

    public function remove($entity)
    {
        $this->userManager->deleteUser($entity);
    }

    /**
     * @param string $first
     * @param string $second
     * @param User $user
     * @return array|bool
     */
    public function changePassword(User $user, $first, $second)
    {
        if ($first != $second)
        {
            return [
                'password' => 'The entered passwords don\'t match'
            ];
        }

        $user->setPlainPassword($first);

        $this->update($user);

        return true;
    }

    /**
     * @param string $contactInfo
     * @return null|User
     */
    public function searchByPhone($contactInfo)
    {
        /** @var QueryBuilder $qb */
//        $qb = $this->em->createQueryBuilder();
//        $query = $qb->select('u')
//            ->from('UserBundle:User', 'u')
//            ->leftJoin('u.groups', 'g')
//            ->where('g.account = :account')
//            ->setParameter('account', $this->getCurrentAccount())
//            ->andwhere('u.phone LIKE :phone')
//            ->setParameter('phone', '%' . preg_replace('/^(?:\+7|8)/', '', $number) . '%')
//            ->setMaxResults(1)
//            ->getQuery();
//
//        return $query->getOneOrNullResult();

        // TODO need implementation search with new logic and using Contact::search() instead this method

        return null;
    }
} 