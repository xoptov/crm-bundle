<?php

namespace Perfico\CRMBundle\Transformer;

use Perfico\CRMBundle\Transformer\Converter\ConverterInterface;
use Perfico\CRMBundle\Transformer\Mapping\MapInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReverseTransformer
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
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
                if ($request->get($value)) {
                    $object->$method($request->get($value));
                }
            } elseif (isset($value['converter']) && is_string($value['converter'])) { // if converter is service then using as service
                /** @var ConverterInterface $converter */
                $converter = $this->container->get($value['converter']);
                $object->$method($converter->convert($request->get($value['path'])));
            } elseif ($value['converter'] instanceof ConverterInterface) { // else trying use object as converter
                $object->$method($value['converter']->convert($request->get($value['path'])));
            }
        }
    }

    /**
     * @param $object
     * @return array|bool
     */
    public function validate($object) {
        $errorList = $this->container->get('perfico_crm.api.error_converter')->validate($object);

        if (($errorList)&&(count($errorList) > 0)) {
            foreach ($errorList as $name => $err) {
                $errorList[$name] = $this->container->get('translator')->trans($err);
            }
        }

        return $errorList;

    }
}