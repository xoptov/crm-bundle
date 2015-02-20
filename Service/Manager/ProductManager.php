<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityRepository;
use Perfico\CRMBundle\Entity\ProductInterface;
use Perfico\CoreBundle\Entity\Product;

class ProductManager extends GenericManager
{
    /**
     * @return ProductInterface[]
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
     * @return ProductInterface
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
     * @param ProductInterface $product
     * @return bool
     */
    public function hasChild(ProductInterface $product)
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
     * @param ProductInterface $product
     * @return ProductInterface[]
     */
    public function getChildren(ProductInterface $product)
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