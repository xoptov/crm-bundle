<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityRepository;
use Perfico\CoreBundle\Entity\Product;

class ProductManager extends GenericManager
{
    /**
     * @return Product[]
     * @todo need refactoring this method
     */
    public function getAccountProducts()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Product');

        return $repo->createQueryBuilder('p')
            ->where('p.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product
     */
    public function create()
    {
        $product = new Product();
        $product->setAccount($this->accountManager->getCurrentAccount());

        return $product;
    }

    /**
     * Check child exists
     *
     * @param Product $product
     * @return bool
     */
    public function hasChild(Product $product)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Product');

        $products = $repo->createQueryBuilder('p')
            ->select('count(p.id)')
            ->where('p.parent = :product')
            ->setParameter('product', $product)
            ->getQuery()
            ->getSingleScalarResult();

        if ($products)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get product children
     *
     * @param Product $product
     * @return Product[]
     */
    public function getChildren(Product $product)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Product');

        return $repo->createQueryBuilder('p')
            ->where('p.parent = :product')
            ->setParameter('product', $product)
            ->getQuery()
            ->getResult();
    }
} 