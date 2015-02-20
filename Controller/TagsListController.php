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

class TagsListController extends Controller
{
    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of all client tags",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/tags-list")
     * @return JsonResponse
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TAG_VIEW_ALL', 'ROLE_TAG_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        /** @var Tag[] $clientTags */
        $clientTags = $this->get('perfico_crm.tag_manager')->getAccountClients();

        $tags = [
            'items' => $this->get('perfico_crm.api.transformer')->transformCollection($clientTags, new TagMap(), 'tags')
        ];

        return new JsonResponse(
            $tags
        );
    }

}
