<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\ActivitiesListMap;
use Perfico\CoreBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ActivitiesListController extends Controller
{
    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of all activities for specified client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}/activities-list")
     * @param Client $client
     * @return JsonResponse
     */
    public function indexAction(Client $client)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($client->getActivities(), new ActivitiesListMap(), 'activities')
        );
    }

}
