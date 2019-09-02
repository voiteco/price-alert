<?php

declare(strict_types=1);

namespace App\Component;

class PriceHelper
{
    /**
     * @param string $oldPrice
     * @param string $newPrice
     *
     * @return float
     */
    public static function calculateDifference(string $oldPrice, string $newPrice): float
    {
        return floatval(bcsub($oldPrice, $newPrice, 2));
    }

    /**
     * @param string $oldPrice
     * @param string $newPrice
     *
     * @return float
     */
    public static function calculateDifferenceInPercent(string $oldPrice, string $newPrice): float
    {
        $negative = false;

        $diff = bcsub($oldPrice, $newPrice, 2);

        if (strpos($diff, '-') === 0) {
            $diff = substr($diff, 1);
            $negative = true;
        }

        $average = bcdiv(bcadd($oldPrice, $newPrice, 2), '2', 2);
        $percentage = bcmul(bcdiv($diff, $average, 2), '100', 2);

        if ($negative) {
            $percentage = '-'.$percentage;
        }

        return floatval($percentage);
    }
}
