<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\UserMap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Perfico\UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @ApiDoc(
     *  section="User",
     *  description="List of all users for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="start", "dataType"="integer", "required"="true"},
     *    {"name"="limit", "dataType"="integer", "required"="true"}
     *   }
     * )
     * @Method("GET")
     * @Route("/users-list")
     * @return JsonResponse
     */
    public function getNotPaginatedAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_USER_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $users = $this->get('perfico_crm.user_manager')->getAccountUsers(1, 100);

        $items = $this->get('perfico_crm.api.transformer')
            ->transformCollection($users, new UserMap(), 'users');

        return new JsonResponse($items);
    }

    /**
     * @ApiDoc(
     *  section="User",
     *  description="List of all users for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="start", "dataType"="integer", "required"="true"},
     *    {"name"="limit", "dataType"="integer", "required"="true"}
     *   }
     * )
     * @Method("GET")
     * @Route("/users-list/{page}/{limit}")
     * @param integer $page
     * @param integer $limit
     * @return JsonResponse
     */
    public function indexAction($page, $limit)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_USER_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        if ((int) $page < 1) {
            $page = 1;
        }

        $users = $this->get('perfico_crm.user_manager')->getAccountUsers($page, $limit);

        $totalItems = $this->get('perfico_crm.user_manager')->getCountAccountUsers();

        $items = $this->get('perfico_crm.api.transformer')
            ->transformCollection($users, new UserMap(), 'users');

        return new JsonResponse(
            [
                'items' => $items,
                'total' => $totalItems,
                'page' => $page
            ]
        );
    }

    /**
     * @ApiDoc(
     *  section="User",
     *  description="Get specified user",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/users/{id}", requirements = {"id" = "\d+" })
     * @param User $user
     * @return JsonResponse
     */
    public function getAction(User $user)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_USER_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($user, new UserMap(), 'users')
        );
    }

    /**
     * @ApiDoc(
     *  section="User",
     *  description="Get current user",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/users/current")
     */
    public function getCurrentAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($user, new UserMap(), 'users')
        );
    }

    /**
     * @ApiDoc(
     *  section="User",
     *  description="Change user password",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("POST")
     * @Route("/users/{id}/change-password")
     * @param User $user
     * @return JsonResponse
     */
    public function changePasswordAction(User $user)
    {
        $request = $this->get('request');

        $userManager = $this->get('perfico_crm.user_manager');

        $first = $request->get('first');
        $second = $request->get('second');

        $errors = $userManager->changePassword($user, $first, $second);

        if (is_array($errors)) {
            return new JsonResponse($errors, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($user, new UserMap(), 'users')
        );
    }

    /**
     * @ApiDoc(
     *  section="User",
     *  description="Create new user",
     *  parameters={
     *    {"name"="firstName", "dataType"="string", "required"="true"},
     *    {"name"="middleName", "dataType"="string", "required"="false"},
     *    {"name"="lastName", "dataType"="string", "required"="false"},
     *    {"name"="email", "dataType"="string", "required"="true"},
     *    {"name"="plainPassword", "dataType"="integer", "required"="true"},
     *    {"name"="group", "dataType"="string", "required"="false"}
     *   },
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("POST")
     * @Route("/users")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_USER_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();

    }

    /**
     * @ApiDoc(
     *  section="User",
     *  description="Remove user",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/users/{id}")
     * @param User $user
     * @return Response
     */
    public function removeAction(User $user)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_USER_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.user_manager')->remove($user);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="User",
     *  description="Update user details",
     *  parameters={
     *    {"name"="firstName", "dataType"="string", "required"="true"},
     *    {"name"="middleName", "dataType"="string", "required"="false"},
     *    {"name"="lastName", "dataType"="string", "required"="false"},
     *    {"name"="email", "dataType"="string", "required"="true"},
     *    {"name"="plainPassword", "dataType"="integer", "required"="false"},
     *    {"name"="group", "dataType"="string", "required"="false"}
     *   },
     *  filters={
     *    {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("PUT")
     * @Route("/users/{id}")
     * @param User $user
     * @return Response
     */
    public function updateAction(User $user)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_USER_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($user);
    }

    /**
     * @param User|null $user
     * @return JsonResponse|Response
     */
    protected function handleRequest(User $user = null)
    {
        $userManager = $this->get('perfico_crm.user_manager');

        if(!$user) {
            $user = $userManager->create();
            $group = 'registration';
        } else {
            $group = null;
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($user, new UserMap());

        if(false != $errors = $transformer->validate($user, $group)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $userManager->update($user);
            $user = $this->get('perfico_crm.api.transformer')
                ->transform($user, new UserMap(), 'users');

            return new JsonResponse($user);
        }
    }
}