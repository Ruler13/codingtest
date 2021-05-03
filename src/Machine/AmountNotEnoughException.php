<?php

namespace App\Machine;

use Throwable;

class AmountNotEnoughException extends \Exception
{

    /**
     * @var float
     */
    private $amount;
    /**
     * AmountNotEnoughException constructor.
     *
     * @param float $amount
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(float $amount = 0.00, int $code = 0, Throwable $previous = null)
    {
        $this->amount = $amount;
        parent::__construct($amount, $code, $previous);
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
