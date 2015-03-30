<?php

namespace Perfico\CRMBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Perfico\CRMBundle\Entity\AccountInterface;
use Perfico\CRMBundle\Service\Manager\AccountManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AccountSubscriber implements EventSubscriberInterface
{
    /** @var EntityManager */
    private $em;

    /** @var AccountManager */
    private $accountManager;

    public function __construct(EntityManager $em, AccountManager $accountManager)
    {
        $this->em = $em;
        $this->accountManager = $accountManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 16)
        );
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $host = $this->accountManager->getHostFromDomain($request->getHost());

        $account = $this->em->getRepository('CoreBundle:Account')->findOneBy(array('domain' => $host));

        if ($account instanceof AccountInterface) {
            $this->accountManager->setCurrentAccount($account);
        }
//        } else {
//            $response = new JsonResponse(['error' => 'Account for ' . $request->getHost() . ' not found'], Response::HTTP_NOT_FOUND);
//            $event->setResponse($response);
//        }
    }
} 