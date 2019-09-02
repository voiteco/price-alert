<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ProductSourceRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductSource::class);
    }

    /**
     * @param ProductSource $productSource
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ProductSource $productSource): void
    {
        $em = $this->getEntityManager();
        $em->persist($productSource);
        $em->flush($productSource);
    }
}
