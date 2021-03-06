<?php

namespace Perfico\CRMBundle\Transformer;

use Perfico\CRMBundle\Transformer\Converter\ConverterInterface;
use Perfico\CRMBundle\Transformer\Mapping\MapInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReverseTransformer
{
    /** @var ContainerInterface */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Populating object from request
     * @param $object
     * @param MapInterface $map
     */
    public function bind($object, MapInterface $map) {

        $request = $this->container->get('request');

        foreach($map->getReverseMap() as $method => $value) {

            /**
             * Check for determine converter between method, class or service
             */
            if(is_string($value)) { // if $value is string then working without converter
                // Checking value for null if request method is PATCH
                if ($request->getMethod() == 'PATCH' && $request->get($value) == null) {
                    continue;
                }
                $object->$method($request->get($value));
            } elseif (isset($value['converter'])) {
                // Checking value for null if request method is PATCH
                if ($request->getMethod() == 'PATCH' && $request->get($value['path']) == null) {
                    continue;
                }
                if (is_string($value['converter'])) {
                    /** @var ConverterInterface $converter */
                    $converter = $this->container->get($value['converter']);
                    if (isset($value['collection']) && $value['collection']) {
                        $children = $converter->convertCollection($request->get($value['path']));
                        empty($children) || $object->$method($children);
                    } else {
                        $child = $converter->convert($request->get($value['path']));
                        $child && $object->$method($child);
                    }
                } elseif ($value['converter'] instanceof ConverterInterface) {
                    if (isset($value['collection']) && $value['collection']) {
                        $children = $value['converter']->convertCollection($request->get($value['path']));
                        empty($children) || $object->$method($children);
                    } else {
                        $child = $value['converter']->convert($request->get($value['path']));
                        $child && $object->$method($child);
                    }
                }
            }
        }
    }

    /**
     * Populating object from data model
     * @param array|ParameterBag $model
     * @param $object
     * @param MapInterface $map
     */
    public function bindContent($model, $object, MapInterface $map)
    {
        foreach ($map->getReverseMap() as $method => $value) {
            if(is_string($value)) { // if $value is string then working without converter
                if (array_key_exists($value, $model)) {
                    $object->$method($model[$value]);
                }

            } elseif (isset($value['converter']) && is_string($value['converter'])) { // if converter is service then using as service
                /** @var ConverterInterface $converter */
                $converter = $this->container->get($value['converter']);
                $child = $converter->convert($model[$value['path']]);
                $child && $object->$method($child);

            } elseif (isset($value['converter']) && $value['converter'] instanceof ConverterInterface) { // else trying use object as converter
                $converter = $value['converter'];
                $child = $converter->convert($model[$value['path']]);
                $child && $object->$method($child);
            }
        }
    }

    /**
     * @param $object
     * @param $groups
     * @return array|bool
     */
    public function validate($object, $groups = null) {
        return $this->container->get('perfico_crm.api.error_converter')->validate($object, $groups);
    }
}