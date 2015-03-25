<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Deal;
use Perfico\CoreBundle\Entity\DealState;

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

        if ($dealState instanceof DealState) {
            return [
                'id' => $dealState->getId(),
                'name' => $dealState->getName(),
                'icon' => $dealState->getIcon()
            ];
        }

        return null;
    }
}