<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ProductPriceRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPrice::class);
    }

    /**
     * @param ProductPrice $productPrice
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ProductPrice $productPrice): void
    {
        $em = $this->getEntityManager();
        $em->persist($productPrice);
        $em->flush($productPrice);
    }
}
