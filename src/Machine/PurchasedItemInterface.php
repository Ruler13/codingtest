<?php

namespace App\Machine;

/**
 * Interface PurchasedItemInterface
 * @package App\Machine
 */
interface PurchasedItemInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity();

    /**
     * @return float
     */
    public function getTotalAmount();

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array
     */
    public function getChange();

    /**
     * returns the amount missing for the payment
     *
     * @return float
     */
    public function getAmountMissing(): float;

    /**
     * return true if some amount is missing
     *
     * @return bool
     */
    public function isSomeAmountMissing(): bool;
}
