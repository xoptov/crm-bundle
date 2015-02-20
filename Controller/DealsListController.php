<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\DealsListMap;
use Perfico\CoreBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DealsListController extends Controller
{
    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of all deals for specified client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}/deals-list")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return JsonResponse
     */
    public function indexAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_VIEW_ALL', 'ROLE_DEAL_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($client->getDeals(), new DealsListMap(), 'deals')
        );
    }

}
