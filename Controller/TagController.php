<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\TagMap;
use Perfico\CoreBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TagController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Tags",
     *  description="List of all tags for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/tags")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TAG_VIEW_ALL', 'ROLE_TAG_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $tags = $this->get('perfico_crm.tag_manager')->getAccountClients();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($tags, new TagMap(), 'tags')
        );
    }

    /**
     * @ApiDoc(
     *  section="Tags",
     *  description="View tag detail information",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/tags/{id}")
     * @ParamConverter("tag", converter="account.doctrine.orm")
     * @param Tag $tag
     * @return JsonResponse
     */
    public function viewAction(Tag $tag)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TAG_VIEW_ALL', 'ROLE_TAG_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($tag, new TagMap(), 'tags')
        );
    }

    /**
     * @ApiDoc(
     *  section="Tags",
     *  description="Create new tag",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"}
     *   }
     * )
     * @Method("POST")
     * @Route("/tags")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TAG_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Tags",
     *  description="Remove tag",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/tags/{id}")
     * @ParamConverter("tag", converter="account.doctrine.orm")
     * @param Tag $tag
     * @return Response
     */
    public function removeAction(Tag $tag)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($tag, 'REMOVE')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.tag_manager')->remove($tag);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Tags",
     *  description="Update tag",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"}
     *   }
     * )
     * @Method("PUT")
     * @Route("/tags/{id}")
     * @ParamConverter("tag", converter="account.doctrine.orm")
     * @param Tag $tag
     * @return Response
     */
    public function updateAction(Tag $tag)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($tag, 'EDIT')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($tag);
    }

    /**
     * @param Tag|null $tag
     * @return JsonResponse|Response
     */
    protected function handleRequest(Tag $tag = null)
    {
        $tagManager = $this->get('perfico_crm.tag_manager');

        if(!$tag) {
            $tag = $tagManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($tag, new TagMap());

        if(false != $errors = $transformer->validate($tag)) {
            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        else
        {
            $tagManager->update($tag);
            $tag = $this->get('perfico_crm.api.transformer')
                ->transform($tag, new TagMap(), 'tags');

            return new JsonResponse($tag);
        }
    }
}
