<?php
declare(strict_types=1);

namespace App\Order;

use App\Assets;
use App\BusPlusService\ProductProfile;
use Exception;

/**
 * Class Item
 *
 * @package App\Order
 */
class Item
{

    /**
     * @var string
     */
    protected $orderNumber;
    /**
     * @var string|null
     */
    protected $aliasNumber;
    /**
     * @var int
     */
    protected $productId;
    /**
     * @var string
     */
    protected $productName;
    /**
     * @var float
     */
    protected $basePrice;
    /**
     * @var float
     */
    protected $vatAmount;
    /**
     * @var float
     */
    protected $productPrice;
    /**
     * @var bool
     */
    protected $isOnKKQueue = false;
    /**
     * @var bool
     */
    protected $isOnWhiteList = false;

    /**
     * Item constructor.
     *
     * @param string|null $aliasNumber
     * @param int|null $productId
     *
     * @throws Exception
     */
    public function __construct(?string $aliasNumber, ?int $productId)
    {
        if ($aliasNumber !== null && $productId !== null) {
            $productProfile = new ProductProfile($productId);
            $this->orderNumber = (new Order)->getOrderNumber();
            $this->aliasNumber = Assets::cleanUpAliasNumber($aliasNumber);
            $this->productId = $productProfile->getProductId();
            $this->productName = $productProfile->getProductName();
            $this->basePrice = $productProfile->getBasePrice();
            $this->vatAmount = $productProfile->getVatAmount();
            $this->productPrice = $productProfile->getPriceWithVAT();
        }
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getAliasNumber(): string
    {
        return $this->aliasNumber;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @return float
     */
    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    /**
     * @return float
     */
    public function getVatAmount(): float
    {
        return $this->vatAmount;
    }

    /**
     * @return float
     */
    public function getProductPrice(): float
    {
        return $this->productPrice;
    }

    /**
     * @return bool
     */
    public function isOnKKQueue(): bool
    {
        return $this->isOnKKQueue;
    }

    /**
     * @return bool
     */
    public function isOnWhiteList(): bool
    {
        return $this->isOnWhiteList;
    }
}
