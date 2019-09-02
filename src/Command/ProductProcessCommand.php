<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Product;
use App\Service\Product\ProductService;
use App\Service\Provider\ProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class ProductProcessCommand extends Command
{
    protected static $defaultName = 'app:product-process';

    /**
     * @var ServiceLocator
     */
    private $providerLocator;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ServiceLocator $providerLocator
     * @param ProductService $productService
     * @param LoggerInterface $logger
     */
    public function __construct(
        ServiceLocator $providerLocator,
        ProductService $productService,
        LoggerInterface $logger
    ) {
        $this->providerLocator = $providerLocator;
        $this->productService = $productService;
        $this->logger = $logger;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->productService->getActive();

        foreach ($products as $product) {
            try {
                $this->processProduct($product);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            sleep(2);
        }
    }

    /**
     * @param Product $product
     *
     * @throws \Exception
     */
    private function processProduct(Product $product): void
    {
        foreach ($product->getSources() as $productSource) {
            $providerUid = $productSource->getProvider()->getUid();

            /** @var ProviderInterface $provider */
            $provider = $this->providerLocator->get($providerUid);
            $price = $provider->getPrice($productSource);

            if ($productSource->isPriceDifferent($price)) {
                $this->productService->updatePrice($productSource, $price);
            }
        }
    }
}
