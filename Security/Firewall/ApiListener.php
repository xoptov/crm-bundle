<?php


namespace Perfico\CRMBundle\Security\Firewall;

use Perfico\CRMBundle\Security\Authentication\Provider\UserProvider;
use Perfico\CRMBundle\Security\Authentication\Token\ApiToken;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class ApiListener implements ListenerInterface
{
    /**
     * @var SecurityContextInterface
     */
    private $securityContext;
    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;
    /**
     * @var UserProvider
     */
    private $userProvider;
    /**
     * @var string
     */
    private $providerId;
    /**
     * @var string
     */
    private $key;

    /**
     * @param SecurityContextInterface $securityContext
     * @param AuthenticationManagerInterface $authenticationManager
     * @param UserProvider $userProvider
     * @param $providerId
     * @param $key
     */
    public function __construct(
        SecurityContextInterface $securityContext,
        AuthenticationManagerInterface $authenticationManager,
        UserProvider $userProvider,
        $providerId,
        $key
    )
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->userProvider = $userProvider;
        $this->providerId = $providerId;
        $this->key = $key;
    }


    /**
     * {@inheritdoc}
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($this->securityContext->getToken() !== null) {
            return ;
        }

        if ($request->getRequestUri() == '/app_dev.php/api/login' || $request->getRequestUri() == '/api/login')
            return;

        //Try to reach token from HTTP headers
        if ($request->headers->has('X-Auth-Token')) {
            $tokenId = $request->headers->get('X-Auth-Token');
        } else {
            $tokenId = $request->get('token');
        }

        //by token
        if (isset($tokenId)) {
            $user = $this->userProvider->findUserByToken($tokenId);

            if (!$user) {
                throw new BadCredentialsException();
            }

            try {
                $token = new ApiToken([], $this->providerId, $this->key);
                $token->setUser($user);
                $authenticatedToken = $this->authenticationManager->authenticate($token);
                $this->securityContext->setToken($authenticatedToken);

            } catch (AuthenticationException $e) {
                //log something
            }
        }
    }

} 