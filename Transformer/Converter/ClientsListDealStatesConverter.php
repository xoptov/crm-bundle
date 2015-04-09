<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Deal;
use Perfico\CRMBundle\Entity\DealStateInterface;

class ClientsListDealStatesConverter extends AbstractEntityConverter
{
    /**
     * @param Deal $object
     * @return array
     */
    public function reverseConvert($object)
    {

        $deal = $this->em->getReference('CoreBundle:Deal', $object->getId());
        $dealState = $deal->getState();

        if ($dealState instanceof DealStateInterface) {
            return [
                'id' => $dealState->getId(),
                'name' => $dealState->getName(),
                'icon' => $dealState->getIcon()
            ];
        }

        return null;
    }
}