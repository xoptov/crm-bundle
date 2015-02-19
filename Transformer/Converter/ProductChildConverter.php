<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CoreBundle\Entity\Product;
use Perfico\CoreBundle\Manager\ProductManager;

class ProductChildConverter extends AbstractEntityConverter
{
    /** @var  ProductManager */
    private $productManager;

    public function setProductManager(ProductManager $pm)
    {
        $this->productManager = $pm;
    }
    /**
     * @param $value
     * @return integer
     */
    public function reverseConvert($value)
    {
        /** @var Product $parentProduct */
        $parentProduct = $this->em->getReference($this->entityClass, $value);

        return $this->productManager->hasChild($parentProduct);
    }
}