<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\GroupMap;
use Perfico\UserBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Perfico\UserBundle\Entity\User;

class GroupController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Group",
     *  description="List of all groups",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/groups")
     * @return JsonResponse
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_GROUPS_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $groups = $this->get('fos_user.group_manager')->findGroups();

        $items = $this->get('perfico_crm.api.transformer')
            ->transformCollection($groups, new GroupMap(), 'groups');

        return new JsonResponse(
            [
                'items' => $items
            ]
        );
    }

    /**
     * @ApiDoc(
     *  section="Group",
     *  description="Get specified group",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/groups/{id}", requirements = {"id" = "\d+" })
     * @param Group $group
     * @return JsonResponse
     */
    public function getAction(Group $group)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_GROUPS_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($group, new GroupMap(), 'groups')
        );
    }

    /**
     * @ApiDoc(
     *  section="Group",
     *  description="Get available roles",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/groups/roles")
     * @return JsonResponse
     */
    public function rolesAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ROLES_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('doctrine')->getRepository('UserBundle:Group')->getRoles()
        );
    }

    /**
     * @ApiDoc(
     *  section="Group",
     *  description="Get current user groups",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/groups/current")
     */
    public function getCurrentAction()
    {
        /** @var User $user */
        $user = $this->get('security.context')->getToken()->getUser();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($user->getGroups(), new GroupMap(), 'groups')
        );
    }

    /**
     * @ApiDoc(
     *  section="Group",
     *  description="Create new group",
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"},
     *    {"name"="roles", "dataType"="string", "required"="false"}
     *   },
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("POST")
     * @Route("/groups")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_GROUPS_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();

    }

    /**
     * @ApiDoc(
     *  section="Group",
     *  description="Remove group",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/groups/{id}")
     * @param Group $group
     * @return Response
     */
    public function removeAction(Group $group)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_GROUPS_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('fos_user.group_manager')->deleteGroup($group);

        return new JsonResponse();
    }

    /**
     * @ApiDoc(
     *  section="Group",
     *  description="Update group details",
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"},
     *    {"name"="roles", "dataType"="string", "required"="false"}
     *   },
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("PUT")
     * @Route("/groups/{id}")
     * @param Group $group
     * @return Response
     */
    public function updateAction(Group $group)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_GROUPS_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($group);
    }

    /**
     * @param Group|null $group
     * @return JsonResponse|Response
     */
    protected function handleRequest($group = null)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_SUPER_ADMIN'])){
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $groupManager = $this->get('fos_user.group_manager');

        if(!$group) {
            $group = new Group('');
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($group, new GroupMap());

        if(false != $errors = $transformer->validate($group)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $groupManager->updateGroup($group, true);
            $groupData = $this->get('perfico_crm.api.transformer')
                ->transform($group, new GroupMap(), 'groups');

            return new JsonResponse($groupData);
        }
    }
}
