<?php

namespace Perfico\CRMBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Perfico\CRMBundle\Service\Manager\AccountManager;
use Perfico\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\SecurityContext;

class AccountListener
{
    /** @var EntityManager */
    private $em;

    /** @var AccountManager */
    private $accountManager;

    /** @var SecurityContext */
    private $securityContext;

    /** @var EngineInterface */
    private $templating;

    public function __construct(EntityManager $em, AccountManager $accountManager, EngineInterface $templating, SecurityContext $sc)
    {
        $this->em = $em;
        $this->accountManager = $accountManager;
        $this->templating = $templating;
        $this->securityContext = $sc;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $host = $this->accountManager->getHostFromDomain($request->getHost());

        if ($account = $this->em->getRepository('CoreBundle:Account')->findOneByDomain($host)) {
            /** @var User $user */
            $user = $this->securityContext->getToken()->getUser();

            if(
                ($user instanceof User) &&
                (
                    ($user->getAccount() != $account) &&
                    (!$this->securityContext->isGranted('ROLE_SUPER_ADMIN'))
                )
            )
            {
                $this->securityContext->setToken(null);

                // todo need refactoring this is sheet
                $template = $this->templating->render(
                    'PerficoWebBundle:Error/Account:not_permitted.html.twig'
                );

                $response = new Response($template);
                $event->setResponse($response);
            }
            else
            {
                $this->accountManager->setCurrentAccount($account);
            }

            return;
        }

        // todo need refactoring this is sheet
        $template = $this->templating->render(
            'PerficoWebBundle:Error/Account:account_not_found.html.twig'
        );

        $response = new Response($template);
        $event->setResponse($response);
    }
} 