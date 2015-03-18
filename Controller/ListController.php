<?php

namespace Perfico\CRMBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Perfico\CRMBundle\Transformer\Mapping\CompanyContactsMap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Perfico\CoreBundle\Entity\Company;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/list")
 */
class ListController extends Controller
{
    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of all clients for specified company",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/companies/{id}/clients")
     * @ParamConverter("company", converter="account.doctrine.orm")
     * @param Company $company
     * @return JsonResponse
     */
    public function companyClientsAction(Company $company)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_VIEW_ALL', 'ROLE_CLIENT_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $account = $this->get('perfico_crm.account_manager')->getCurrentAccount();

        $clients = $this->getDoctrine()->getRepository('CoreBundle:Client')
            ->findBy(array('company' => $company, 'account' => $account));

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($clients, new CompanyContactsMap(), 'clients'));
    }
} 