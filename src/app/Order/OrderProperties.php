<?php
declare(strict_types=1);

namespace App\Order;

/**
 * Class OrderProperties
 * @package App\Order
 */
class OrderProperties
{

    /** @var array */
    public $gatewayResponse;
    /** @var bool */
    public $isFinished;
    /** @var bool */
    public $isCharged;
    /** @var string */
    private $orderNumber;
    /** @var float */
    private $transactionAmount;

    /**
     * OrderProperties constructor.
     */
    public function __construct()
    {
        $order = new Order();
        $this->orderNumber = $order->getOrderNumber();
        $this->transactionAmount = $order->getTransactionAmount();
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @return float
     */
    public function getTransactionAmount(): float
    {
        return $this->transactionAmount;
    }
}
