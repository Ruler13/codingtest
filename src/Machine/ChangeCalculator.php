<?php

namespace App\Machine;

class ChangeCalculator
{
    /**
     * @var array A list of available cash values
     */
    private static $availableCash = [
        500.00,
        200.00,
        100.00,
        50.00,
        20.00,
        10.00,
        5.00,
        2.00,
        1.00,
        0.50,
        0.20,
        0.10,
        0.05,
        0.02,
        0.01,
    ];

    /**
     * @param float $totalMissing
     * @return array
     */
    public static function calculate(float $totalMissing): array
    {
        $totalInCash = [];
        foreach (self::$availableCash as $cash) {
            // Multiply by 100 and ceil to avoid calculation with floating numbers
            $count = self::calculateCash(ceil($totalMissing * 100), $cash * 100);
            if ($count > 0) {
                $totalInCash[] = [sprintf('%.2f', $cash), $count];
                $totalMissing -= $cash * $count;
            }
        }

        return $totalInCash;
    }

    /**
     * @param int $totalMissing
     * @param int $cash
     * @return int
     */
    private static function calculateCash(int $totalMissing, int $cash): int
    {
        if ($totalMissing < $cash) {
            return 0;
        }

        return self::calculateCash($totalMissing - $cash, $cash) + 1;
    }
}
