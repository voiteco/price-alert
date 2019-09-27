<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Component\PriceHelper;
use App\Entity\Product;
use App\Entity\ProductPrice;
use App\Entity\ProductSource;
use App\Repository\ProductPriceRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductSourceRepository;
use App\Service\Notification\NotificationService;
use Symfony\Component\HttpFoundation\File\File;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductSourceRepository
     */
    private $productSourceRepository;

    /**
     * @var ProductPriceRepository
     */
    private $productPriceRepository;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @param ProductRepository       $productRepository
     * @param ProductSourceRepository $productSourceRepository
     * @param ProductPriceRepository  $productPriceRepository
     * @param NotificationService     $notificationService
     */
    public function __construct(
        ProductRepository $productRepository,
        ProductSourceRepository $productSourceRepository,
        ProductPriceRepository $productPriceRepository,
        NotificationService $notificationService
    ) {
        $this->productRepository = $productRepository;
        $this->productSourceRepository = $productSourceRepository;
        $this->productPriceRepository = $productPriceRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * @return Product[]
     */
    public function getActive(): array
    {
        return $this->productRepository->findActive();
    }

    /**
     * @param ProductSource $productSource
     * @param string        $price
     *
     * @throws \Exception
     */
    public function updatePrice(ProductSource $productSource, string $price): void
    {
        $latestPrice = $productSource->getLatestPrice();

        $productPrice = ProductPrice::create($productSource, $price);
        $this->productPriceRepository->save($productPrice);

        $productSource->updateLatestPrice($price);
        $this->productSourceRepository->save($productSource);

        $this->sendPriceAlert($productSource, $latestPrice);
    }

    /**
     * @param ProductSource $productSource
     * @param string        $oldPrice
     */
    public function sendPriceAlert(ProductSource $productSource, string $oldPrice): void
    {
        $difference = PriceHelper::calculateDifferenceInPercent($oldPrice, $productSource->getLatestPrice());

        if (bccomp($difference, '1', 2) < 1) {
            return;
        }

        $product = $productSource->getProduct();
        $dto = new ProductDto(
            $product->getName(),
            $product->getProductUrl(),
            $product->getImageUrl(),
            $oldPrice,
            $productSource->getLatestPrice(),
            $difference
        );

        $this->notificationService->send(
            NotificationService::PRICE_ALERT_ACTION,
            $dto->asArray()
        );
    }
}
