<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\DealMap;
use Perfico\CRMBundle\Transformer\Mapping\ProductMap;
use Perfico\CoreBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Product",
     *  description="List of all products for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/products")
     */
    public function indexAction()
    {
        $products = $this->get('perfico_crm.product_manager')->getAccountProducts();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($products, new ProductMap(), 'products')
        );
    }

    /**
     * @ApiDoc(
     *  section="Product",
     *  description="Get specified product",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/products/{id}")
     * @ParamConverter("product", converter="safe.doctrine.orm")
     * @param Product $product
     * @return JsonResponse|Response
     */
    public function getAction(Product $product)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($product, new ProductMap(), 'products')
        );
    }

    /**
     * @ApiDoc(
     *  section="Product",
     *  description="Create new product",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"},
     *    {"name"="sku", "dataType"="text", "required"="false"},
     *    {"name"="parent", "dataType"="integer", "required"="false"},
     *    {"name"="amount", "dataType"="float", "required"="true"}
     *   }
     * )
     * @Method("POST")
     * @Route("/product")
     * @return Response|JsonResponse
     */
    public function createAction()
    {
        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Product",
     *  description="Remove product",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/products/{id}")
     * @ParamConverter("product", converter="safe.doctrine.orm")
     * @param Product $product
     * @return Response
     */
    public function removeAction(Product $product)
    {
        $this->get('perfico_crm.product_manager')->remove($product);

        return new JsonResponse();
    }

    /**
     * @ApiDoc(
     *  section="Product",
     *  description="Update product details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"},
     *    {"name"="sku", "dataType"="text", "required"="false"},
     *    {"name"="parent", "dataType"="integer", "required"="false"},
     *    {"name"="amount", "dataType"="float", "required"="true"}
     *   }
     * )
     * @Method("PUT")
     * @Route("/products/{id}")
     * @ParamConverter("product", converter="safe.doctrine.orm")
     * @param Product $product
     * @return Response
     */
    public function updateAction(Product $product)
    {
        return $this->handleRequest($product);
    }

    /**
     * @ApiDoc(
     *  section="Product",
     *  description="Get parent product of specified product",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/products/{id}/parent")
     * @ParamConverter("product", converter="safe.doctrine.orm")
     * @param Product $product
     * @return JsonResponse
     */
    public function parentProductAction(Product $product)
    {
        if ($product->getParent())
        {
            return new JsonResponse(
                $this->get('perfico_crm.api.transformer')
                    ->transform($product->getParent(), new ProductMap(), 'products')
            );
        }
        else
            return new JsonResponse();
    }

    /**
     * @ApiDoc(
     *  section="Product",
     *  description="Get deals on specified product",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/products/{id}/deals")
     * @ParamConverter("product", converter="safe.doctrine.orm")
     * @param Product $product
     * @return JsonResponse
     */
    public function dealsProductAction(Product $product)
    {
        if ($product->getDeals())
        {
            return new JsonResponse(
                $this->get('perfico_crm.api.transformer')
                    ->transformCollection($product->getDeals(), new DealMap(), 'deals')
            );
        }
        else
            return new JsonResponse();
    }

    /**
     * @ApiDoc(
     *  section="Product",
     *  description="Get children products of specified product",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/products/{id}/children")
     * @ParamConverter("product", converter="safe.doctrine.orm")
     * @param Product $product
     * @return JsonResponse
     */
    public function childrenProductsAction(Product $product)
    {
        if ($product->getChildren())
        {
            return new JsonResponse(
                $this->get('perfico_crm.api.transformer')
                    ->transformCollection($product->getChildren(), new ProductMap(), 'products')
            );
        }
        else
            return new JsonResponse();
    }

    /**
     * Handle request for products process
     * @param Product $product
     * @return JsonResponse|Response
     */
    protected function handleRequest(Product $product = null)
    {
        $productManager = $this->get('perfico_crm.product_manager');

        if(!$product) {
            $product = $productManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($product, new ProductMap());

        if(false != $errors = $transformer->validate($product)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $productManager->update($product);
            return new JsonResponse();
        }
    }
} 