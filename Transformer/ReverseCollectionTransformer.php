<?php

namespace Perfico\CRMBundle\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use Perfico\CRMBundle\Transformer\Mapping\MapInterface;
use Perfico\CRMBundle\Transformer\Factory\ObjectFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReverseCollectionTransformer extends ReverseTransformer
{
    /** @var mixed */
    private $aggregator;

    /** @var ArrayCollection */
    private $collection;

    /** @var MapInterface */
    private $map;

    /** @var ObjectFactoryInterface */
    private $factory;

    /** @var ArrayCollection */
    private $exists;

    /** @var ArrayCollection */
    private $new;

    /** @var ArrayCollection */
    private $result;

    /** @var ArrayCollection */
    private $errors;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->exists = new ArrayCollection();
        $this->new = new ArrayCollection();
        $this->result = new ArrayCollection();
        $this->errors = new ArrayCollection();
    }

    /**
     * @param array $collection
     * @param MapInterface $map
     * @param ObjectFactoryInterface|string $factory
     * @param null $aggregator
     * @throws \InvalidArgumentException
     */
    public function processing(array $collection, MapInterface $map, $factory, $aggregator = null)
    {
        $this->aggregator = $aggregator;
        $this->collection = new ArrayCollection($collection);
        $this->map = $map;

        // Checking type of factory and then set as internal tool
        if (is_string($factory)) {
            $this->factory = $this->container->get($factory);
        } else {
            $this->factory = $factory;
        }

        if (count($collection) == 0) {
            throw new \InvalidArgumentException('Collection can\'t be null');
        }

        // Split collection to "new" and "exists"
        $this->ranking();

        // If collection "exists" not empty, then load items form database
        if (!$this->exists->isEmpty()) {
            $this->loadExistsObjects();
        }

        // If collection "new" not empty, then create new entities
        if (!$this->new->isEmpty()) {
            $this->createNewObjects();
        }

        // Clean internal "common" collection
        $this->collection->clear();

        // Clean aggregator
        $this->aggregator = null;
    }

    /**
     * Method for separating collection to "exists" and "new" items
     */
    public function ranking()
    {
        foreach ($this->collection as $key => $item) {
            // Extending each array element by number field
            $item['number'] = $key;
            if (isset($item['id']) && $item['id']) {

                // Add item to "exists" collection
                $this->exists->add($item);
            } else {

                // Add item to "new" collection
                $this->new->add($item);
            }

            // Clear result for memory free
            $this->collection->remove($key);
        }
    }

    /**
     * Method for trying load objects via factory
     */
    public function loadExistsObjects()
    {
        $ids = array_column($this->exists->toArray(), 'id');
        // Try loading objects by ids via factory
        $loaded = $this->factory->load($ids);

        if (count($loaded)) {
            /** @var TransformableInterface $object */
            foreach ($loaded as $object) {
                foreach ($this->exists as $item) {

                    // If object has id equivalent item id then item has new description for that object
                    if ($object->getId() == $item['id']) {

                        // Populate object from item description
                        $this->bindContent($item, $object, $this->map);

                        // Validate and retrieve errors if exists
                        if ($errors = $this->validate($object)) {
                            $this->errors->add(array('item' => $item['number'], 'errors' => $errors));
                        } else {
                            $this->result->add($object);
                        }
                        // Clean internal "exists" collection for memory free
                        $this->exists->removeElement($item);
                    }
                }
            }
        }

        // Join not found item in db into "new" collection
        foreach ($this->exists as $item) {
            $this->new->add($item);
            // Clean internal "exists" collection
            $this->exists->removeElement($item);
        }
    }

    /**
     * Method for create new objects
     */
    public function createNewObjects()
    {
        foreach ($this->new as $item) {
            // Create new object via factory
            $object = $this->factory->create($this->aggregator);

            // Populate new object from item description
            $this->bindContent($item, $object, $this->map);

            // Validate and retrieve errors if validation fail
            if ($errors = $this->validate($object)) {
                $this->errors->add(array('item' => $item['number'], 'errors' => $errors));
            } else {
                $this->result->add($object);
            }
            // Clean internal "new" collection for memory free
            $this->new->removeElement($item);
        }
    }

    /**
     * Method for retrieving processing result
     * @return ArrayCollection
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Method for retrieving errors after processing
     * @return ArrayCollection
     */
    public function getErrors()
    {
        return $this->errors;
    }
} 