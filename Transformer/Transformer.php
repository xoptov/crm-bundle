<?php

namespace Perfico\DosalesBundle\Transformer;

use Perfico\DosalesBundle\Transformer\Converter\ConverterInterface;
use Perfico\DosalesBundle\Transformer\Mapping\MapInterface;
use Perfico\ApiBundle\Permissions\PermissionManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
     * @param $objects
     * @param MapInterface $map
     * @return array
     */
    public function transform($objects, MapInterface $map)
    {
        $output = [];
        foreach ($objects as $object) {
            // Iterate by map
            $fields = [];
            foreach($map->getMap() as $path => $callback) {
                if (is_string($callback)) {
                    $fields[$path] = $object->$callback();
                } elseif (isset($callback['converter']) && is_string($callback['converter'])) {
                    /** @var ConverterInterface $converter */
                    $converter = $this->container->get($callback['converter']);
                    $fields[$path] = $converter->reverseConvert($object->$callback['method']());
                } elseif ($callback['converter'] instanceof ConverterInterface) {
                    $fields[$path] = $callback['converter']->reverseConvert($object->$callback['method']());
                }
            }
            $fields += $this->permissionManager->getPermissions($object);
            array_push($output, $fields);
        }

        return $output;
    }
}