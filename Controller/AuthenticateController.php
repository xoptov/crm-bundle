<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Entity\AuthToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Perfico\CRMBundle\Security\Authentication\Token\ApiToken;

class AuthenticateController extends Controller
{
    /**
     * Expiration time default: "1 hour".
     * Format of DateTime string.
     *
     * @ApiDoc(
     *  section="Authenticate",
     *  description="Login action. Expiration time default: 1 hour",
     *  filters={
     *     {"name"="username", "type"="text"},
     *     {"name"="password", "type"="text"},
     *     {"name"="expirationTime", "type"="text"}
     *  }
     * )
     *
     * @Route("/login", options={"expose" = true})
     * @Method("POST")
     */
    public function loginAction(Request $request)
    {
        $username = $request->request->get('username');
        $presentedPassword = $request->request->get('password');
        $expirationTime = $request->request->get('expirationTime', AuthToken::EXPIRATION_TIME);

        if (!$username || !$presentedPassword) {
            return new JsonResponse(['error' => 'Username and password must not be blank'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->get('fos_user.user_manager')->findUserByUsername($username);

        if (!$user) {
            return new JsonResponse(['error' => 'User with  this username and password not found'], Response::HTTP_FORBIDDEN);
        }

        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        if (!$encoder->isPasswordValid($user->getPassword(), $presentedPassword, $user->getSalt())) {
            return new JsonResponse(['error' => 'User with  this username and password not found'], Response::HTTP_FORBIDDEN);
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $authToken = $this->get('perfico_crm.auth_token_manager')->generate($user, $expirationTime);
        $em->persist($authToken);
        $em->flush();

        $result = [
            'token' =>  $authToken->getToken()
        ];

        return new JsonResponse($result);
    }
} 