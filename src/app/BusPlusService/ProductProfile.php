<?php
declare(strict_types=1);

namespace App\BusPlusService;

use Exception;
use stdClass;

/**
 * Class ProductProfile
 *
 * @package App\BusPlusService
 */
final class ProductProfile extends Service
{

    /**
     * @var bool
     */
    protected $exists;
    /**
     * @var bool
     */
    protected $suspended;
    /**
     * @var int|null
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
    protected $priceWithVAT;

    /**
     * ProductProfile constructor.
     *
     * @param int $productId
     *
     * @throws Exception
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
        parent::__construct($this->productProfileURI($productId));
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return $this->exists;
    }

    /**
     * @param bool $exists
     */
    protected function setExists(bool $exists): void
    {
        $this->exists = $exists;
    }

    /**
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->suspended;
    }

    /**
     * @param bool $suspended
     */
    protected function setSuspended(bool $suspended): void
    {
        $this->suspended = $suspended;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    protected function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    protected function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @return float
     */
    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    /**
     * @param float $basePrice
     */
    protected function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @return float
     */
    public function getVatAmount(): float
    {
        return $this->vatAmount;
    }

    /**
     * @param float $vatAmount
     */
    protected function setVatAmount(float $vatAmount): void
    {
        $this->vatAmount = $vatAmount;
    }

    /**
     * @return float
     */
    public function getPriceWithVAT(): float
    {
        return $this->priceWithVAT;
    }

    /**
     * @param float $priceWithVAT
     */
    protected function setPriceWithVAT(float $priceWithVAT): void
    {
        $this->priceWithVAT = $priceWithVAT;
    }

    /**
     * @param stdClass $guzzleClientResponse
     */
    protected function responseData(stdClass $guzzleClientResponse): void
    {
        $this->setExists($guzzleClientResponse->exists);
        $this->setSuspended($guzzleClientResponse->suspended);
        $this->setProductId($guzzleClientResponse->product_profile->product_id);
        $this->setProductName($guzzleClientResponse->product_profile->product_name);
        $this->setBasePrice($guzzleClientResponse->product_profile->base_price);
        $this->setVatAmount($guzzleClientResponse->product_profile->tax);
        $this->setPriceWithVAT($guzzleClientResponse->product_profile->total_price);
    }
}
