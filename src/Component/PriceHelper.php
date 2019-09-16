<?php

declare(strict_types=1);

namespace App\Component;

class PriceHelper
{
    /**
     * @param string $oldPrice
     * @param string $newPrice
     *
     * @return string
     */
    public static function calculateDifference(string $oldPrice, string $newPrice): string
    {
        return bcsub($oldPrice, $newPrice, 2);
    }

    /**
     * @param string $oldPrice
     * @param string $newPrice
     *
     * @return string
     */
    public static function calculateDifferenceInPercent(string $oldPrice, string $newPrice): string
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

        return $percentage;
    }
}
