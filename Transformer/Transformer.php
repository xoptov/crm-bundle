<?php

namespace Perfico\CRMBundle\Transformer;

use Perfico\CRMBundle\Transformer\Converter\ConverterInterface;
use Perfico\CRMBundle\Transformer\Mapping\MapInterface;
use Perfico\CRMBundle\Permissions\PermissionManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Transformer {

    /** @var ContainerInterface */
    protected $container;

    /**
     * @var PermissionManager
     */
    private $permissionManager;

    /**
     * @param ContainerInterface $container
     * @param PermissionManager $permissionManager
     */
    public function __construct(ContainerInterface $container, PermissionManager $permissionManager)
    {
        $this->container = $container;
        $this->permissionManager = $permissionManager;
    }

    /**
     * Transform one object
     *
     * @param $object
     * @param MapInterface $map
     * @return array
     */
    public function transform($object, MapInterface $map)
    {
        // Iterate by map
        $fields = [];
        foreach($map->getMap() as $path => $callback) {
            if (is_string($callback)) {
                $fields[$path] = $object->$callback();
            } elseif (isset($callback['converter']) && is_string($callback['converter'])){
                /** @var ConverterInterface $converter */
                $converter = $this->container->get($callback['converter']);
                $fields[$path] = $converter->reverseConvert($object->$callback['method']());
            } elseif (isset($callback['converter']) && $callback['converter'] instanceof ConverterInterface) {
                /** @var ConverterInterface $converter */
                $converter = $callback['converter'];
                $fields[$path] = $converter->reverseConvert($object->$callback['method']());
            }
        }

        $fields += $this->permissionManager->getPermissions($object);

        return $fields;
    }

    /**
     * @param array|ArrayCollection $objects
     * @param MapInterface $map
     * @return array
     */
    public function transformCollection($objects, MapInterface $map)
    {
        $output = [];
        foreach ($objects as $object) {
            // Iterate by map
            $fields = $this->transform($object, $map);
            array_push($output, $fields);
        }

        return $output;
    }
}