<?php

namespace Perfico\CRMBundle\Transformer\Converter;

class TagConverter extends AbstractEntityConverter
{
    /**
     * @param $value
     * @return mixed|void
     */
    public function convert($value)
    {
        if (is_array($value))
        {
            $clientTags = [];

            foreach($value as $tag)
            {
                $clientTags[] = $this->em->getReference($this->entityClass, (int)$tag);
            }

            return $clientTags;
        }
    }

    /**
     * @param $objects
     * @return integer
     */
    public function reverseConvert($objects)
    {
        if (!$objects)
            return [];

        $clientTags = [];
        foreach($objects as $object)
        {
            if (is_object($object) && method_exists($object, 'getId')) {
                $clientTags[] = $object->getId();
            }
        }
        return $clientTags;

    }
} 