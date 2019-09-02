<?php

declare(strict_types=1);

namespace App\Service\Provider;

use App\Entity\ProductSource;

interface ProviderInterface
{
    /**
     * @return string
     */
    public function uid(): string;

    /**
     * @param ProductSource $productSource
     *
     * @return string
     */
    public function getPrice(ProductSource $productSource): string;
}
