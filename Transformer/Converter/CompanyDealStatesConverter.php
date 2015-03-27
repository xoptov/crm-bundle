<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\ClientInterface;
use Perfico\CRMBundle\Entity\DealStateInterface;

class CompanyDealStatesConverter extends AbstractEntityConverter
{
    public function reverseConvertCollection($objects)
    {
        $condition = [];

        /** @var ClientInterface $object */
        foreach ($objects as $object) {
            $condition[] = $object->getId();
        }

        $qb = $this->em->createQueryBuilder();
        $qb->select('ds')
            ->from('CoreBundle:DealState', 'ds')
            ->leftJoin('ds.deals', 'd')
            ->where('d.client IN (:clients)')
            ->setParameter('clients', $condition)
            ->groupBy('ds');

        $result = $qb->getQuery()->getResult();
        $dealStates = [];

        /** @var DealStateInterface $item */
        foreach ($result as $item) {
            $dealStates[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'icon' => $item->getIcon()
            ];
        }

        return $dealStates;
    }
} 