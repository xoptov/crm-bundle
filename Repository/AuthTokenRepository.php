<?php

namespace Perfico\CRMBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AuthTokenRepository extends EntityRepository
{
    /**
     * @param $token
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNotExpired($token)
    {
        $now = new \DateTime();
        $qb = $this->createQueryBuilder('at');

        $query = $qb->where('at.token = :token')
            ->setParameter('token', $token)
            ->andWhere('at.expireAt > :now')
            ->setParameter('now', $now)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
} 