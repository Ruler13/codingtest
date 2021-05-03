<?php

namespace App\Machine;

trait ChangeCalculator
{
    /**
     * @var array A list of available cash values
     */
    private $availableCash = [
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
    public function calculate(float $totalMissing): array
    {
        $totalInCash = [];
        foreach ($this->availableCash as $cash) {
            // Use round function to round off the floating value upto two decimal place
            // Avoid unexpected comparision result with float
            $count = $this->calculateCash(round($totalMissing, 2), $cash);
            if ($count > 0) {
                $totalInCash[] = [sprintf('%.2f', $cash), $count];
                $totalMissing -= $cash * $count;
            }
        }

        return $totalInCash;
    }

    /**
     * @param float $totalMissing
     * @param float $cash
     * @return int
     */
    private function calculateCash(float $totalMissing, float $cash): int
    {
        if ($totalMissing < $cash) {
            return 0;
        }

        return $this->calculateCash($totalMissing - $cash, $cash) + 1;
    }
}
