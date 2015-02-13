<?php

namespace Perfico\CRMBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiLogoutHandler implements LogoutSuccessHandlerInterface
{
    public function onLogoutSuccess(Request $request)
    {
         return new JsonResponse([]);
    }
} 