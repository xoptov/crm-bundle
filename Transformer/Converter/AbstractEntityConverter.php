<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Doctrine\ORM\EntityManagerInterface;

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
     * @param $value
     * @return mixed|null
     */
    public function convert($value)
    {
        if ($value) {
            return $this->em->getReference($this->entityClass, $value);
        }

        return null;
    }

    /**
     * @param $object
     * @return integer
     */
    public function reverseConvert($object)
    {
        if (is_object($object) && method_exists($object, 'getId')) {
            return $object->getId();
        }
    }
} 