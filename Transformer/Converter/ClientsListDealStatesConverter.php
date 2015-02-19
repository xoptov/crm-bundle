<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Deal;
use Perfico\CoreBundle\Entity\DealState;

class ClientsListDealStatesConverter extends AbstractEntityConverter
{
    /**
     * @param Deal[] $objects
     * @return array
     */
    public function reverseConvert($objects)
    {
        $states = [];

        foreach ($objects as $object) {
            /**
             * @var Deal $deal
             */
            $deal = $this->em->getReference('CoreBundle:Deal', $object->getId());
            $dealState = $deal->getState();
            if ($dealState instanceof DealState) {
                $states[] = [
                    'id' => $dealState->getId(),
                    'name' => $dealState->getName(),
                    'icon' => $dealState->getIcon()
                ];
            }
        }
        return $states;
    }
}