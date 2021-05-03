<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @throws AmountNotEnoughException
     * @return PurchasedItemInterface
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface
    {
        $purchasedItem = new PurchasedItem($purchaseTransaction);
        if ($purchasedItem->isSomeAmountMissing()) {
            throw new AmountNotEnoughException($purchasedItem->getAmountMissing());
        }

        return $purchasedItem;
    }
}
