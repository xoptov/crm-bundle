<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Doctrine\Common\Collections\ArrayCollection;
use Perfico\CRMBundle\Entity\ActivityInterface;

class LastActivityConverter extends AbstractEntityConverter
{
    public function reverseConvertCollection($objects)
    {
        /**
         * @var ArrayCollection $objects
         * @var ActivityInterface $activity
         */
        $activity = $objects->last();


        if ($activity instanceof ActivityInterface) {
            $qb = $this->em->createQueryBuilder();
            $query = $qb->select('a')
                ->from('CoreBundle:Activity', 'a')
                ->where('a.user = :user')->setParameter('user', $activity->getUser())
                ->setMaxResults(1)
                ->orderBy('a.createdAt', 'DESC')
                ->getQuery();

            $last = $query->getOneOrNullResult();

            if ($last instanceof ActivityInterface) {
                $converter = new DateTimeConverter();
                return [
                    'id' => $last->getId(),
                    'createdAt' => $converter->reverseConvert($last->getCreatedAt()),
                    'updatedAt' => $converter->reverseConvert($last->getUpdatedAt()),
                    'note' => $last->getNote(),
                    'type' => $last->getType()
                ];
            }
        }

        return null;
    }
} 