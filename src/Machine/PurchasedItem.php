<?php

namespace App\Machine;

class PurchasedItem implements PurchasedItemInterface
{
    use ChangeCalculator;

    /**
     * @var PurchaseTransactionInterface
     */
    private $purchaseTransaction;

    /**
     * PurchasedItem constructor.
     *
     * @param PurchaseTransactionInterface $purchaseTransaction
     */
    public function __construct(PurchaseTransactionInterface $purchaseTransaction)
    {
        $this->purchaseTransaction = $purchaseTransaction;
    }

    /**
     * @return integer
     */
    public function getItemQuantity(): int
    {
        return $this->purchaseTransaction->getItemQuantity();
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->purchaseTransaction->getItemQuantity() * CigaretteMachine::ITEM_PRICE;
    }

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
    public function getChange(): array
    {
        return $this->calculate(
            $this->purchaseTransaction->getPaidAmount() - $this->getTotalAmount()
        );
    }

    /**
     * returns the amount missing for the payment
     *
     * @return float
     */
    public function getAmountMissing(): float
    {
        $amountMissing = $this->getTotalAmount() - $this->purchaseTransaction->getPaidAmount();
        if ($amountMissing > 0) {
            return $amountMissing;
        }
        return 0;
    }

    /**
     * return true if some amount is missing
     *
     * @return bool
     */
    public function isSomeAmountMissing(): bool
    {
        return $this->getAmountMissing() > 0;
    }
}
