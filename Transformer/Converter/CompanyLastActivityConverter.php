<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class CompanyLastActivityConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('a')->from('CoreBundle:Activity', 'a')
            ->innerJoin('a.client', 'c')
            ->where('c.company = :company')->setParameter('company', $object)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(1);

        $activity = $qb->getQuery()->getOneOrNullResult();

        if ($activity) {
            return [
                'id' => $activity->getId(),
                'createdAt' => $activity->getCreatedAt()
            ];
        }

        return null;
    }
} 