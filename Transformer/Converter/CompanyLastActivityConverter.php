<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\ActivityInterface;

class CompanyLastActivityConverter extends AbstractEntityConverter
{
    public function reverseConvert($object)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('a')
            ->from('CoreBundle:Activity', 'a')
            ->leftJoin('a.client', 'c')
            ->where('c.company = :company')->setParameter('company', $object)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(1);

        $activity = $qb->getQuery()->getOneOrNullResult();

        if ($activity instanceof ActivityInterface) {
            $dateConverter = new DateTimeConverter();
            return [
                'id' => $activity->getId(),
                'createdAt' => $dateConverter->reverseConvert($activity->getCreatedAt())
            ];
        }

        return null;
    }
} 