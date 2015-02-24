<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

/**
 * This class needed as start point for inheritance by children services
 */
abstract class AbstractEntityConverter implements ConverterInterface
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var string */
    protected $entityClass;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $class
     */
    public function setEntityClass($class)
    {
        $this->entityClass = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($value)
    {
        if ($value) {
            return $this->em->getReference($this->entityClass, $value);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function convertCollection($values)
    {
        $collection = [];

        if (is_array($values) && !empty($values)) {
            foreach ($values as $value) {
                if ($item = $this->convert($value))
                    $collection[] = $item;
            }
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseConvert($object)
    {
        if (is_object($object) && method_exists($object, 'getId')) {
            return $object->getId();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseConvertCollection($objects)
    {
        $collection = [];

        if ($objects instanceof Collection) {
            foreach ($objects as $object) {
                if ($item = $this->reverseConvert($object)) {
                    $collection[] = $item;
                }
            }
        }

        return $collection;
    }
} 