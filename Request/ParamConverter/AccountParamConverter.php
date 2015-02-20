<?php

namespace Perfico\CRMBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\NoResultException;
use Doctrine\Common\Persistence\ManagerRegistry;
use Perfico\CRMBundle\Service\Manager\AccountManager;

class AccountParamConverter extends DoctrineParamConverter
{
    /** @var AccountManager */
    protected $accountManager;

    public function __construct(ManagerRegistry $managerRegistry, AccountManager $accountManager)
    {
        parent::__construct($managerRegistry);
        $this->accountManager = $accountManager;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $name    = $configuration->getName();
        $class   = $configuration->getClass();
        $options = $this->getOptions($configuration);

        if (null === $request->attributes->get($name, false)) {
            $configuration->setIsOptional(true);
        }

        // find by identifier?
        if (false === $object = $this->find($class, $request, $options, $name)) {
            if ($configuration->isOptional()) {
                $object = null;
            } else {
                throw new \LogicException('Unable to guess how to get a Doctrine instance from the request information.');
            }
        }

        if (null === $object && false === $configuration->isOptional()) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $class));
        }

        $request->attributes->set($name, $object);

        return true;
    }

    protected function find($class, Request $request, $options, $name)
    {
        if ($options['mapping'] || $options['exclude']) {
            return false;
        }

        $id = $this->getIdentifier($request, $options, $name);

        if (false === $id || null === $id) {
            return false;
        }

        $criteria = array('id' => $id, 'account' => $this->accountManager->getCurrentAccount());

        try {
            return $this->getManager($options['entity_manager'], $class)->getRepository($class)->findOneBy($criteria);
        } catch (NoResultException $e) {
            return null;
        }
    }

    private function getManager($name, $class)
    {
        if (null === $name) {
            return $this->registry->getManagerForClass($class);
        }

        return $this->registry->getManager($name);
    }
}
