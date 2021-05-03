<?php

namespace App\Machine;

class PurchaseTransaction implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private $itemCount;

    /**
     * @var float
     */
    private $amount;

    /**
     * PurchaseTransaction constructor.
     *
     * @param int $itemCount purchased quantity
     * @param int $amount paid amount
     */
    public function __construct($itemCount, $amount)
    {
        $this->itemCount = $itemCount;
        $this->amount = $amount;
    }

    /**
     * @return integer
     */
    public function getItemQuantity(): int
    {
        return $this->itemCount;
    }

    /**
     * @return float
     */
    public function getPaidAmount(): float
    {
        return $this->amount;
    }
}
