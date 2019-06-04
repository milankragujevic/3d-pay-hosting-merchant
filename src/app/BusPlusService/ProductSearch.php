<?php
declare(strict_types=1);

namespace App\BusPlusService;

use App\Logger;
use DateTime;
use Exception;
use RuntimeException;
use stdClass;

/**
 * Class ProductSearch
 *
 * @package App\BusPlusService
 */
final class ProductSearch extends Service
{

    /**
     * @var string|null
     */
    protected $aliasNumber;
    /**
     * @var int|null
     */
    protected $productId;
    /**
     * @var float|null
     */
    protected $productPrice;
    /**
     * @var DateTime|null
     */
    protected $validFrom;
    /**
     * @var DateTime|null
     */
    protected $validUntil;

    /**
     * ProductSearch constructor.
     *
     * @param string $aliasNumber
     * @param int $rechargeTypeId
     * @param int $zoneId
     *
     * @throws Exception
     */
    public function __construct(string $aliasNumber, int $rechargeTypeId, int $zoneId)
    {
        $this->aliasNumber = $aliasNumber;
        parent::__construct($this->searchProductURI($aliasNumber, $rechargeTypeId, $zoneId));
    }

    /**
     * @return string|null
     */
    public function getAliasNumber(): ?string
    {
        return $this->aliasNumber;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     */
    protected function setProductId(?int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return float|null
     */
    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    /**
     * @param float|null $productPrice
     */
    protected function setProductPrice(?float $productPrice): void
    {
        $this->productPrice = $productPrice;
    }

    /**
     * @return DateTime|null
     */
    public function getValidFrom(): ?DateTime
    {
        return $this->validFrom;
    }

    /**
     * @param string|null $validFrom
     *
     * @throws Exception
     */
    protected function setValidFrom(?string $validFrom): void
    {
        try {
            $this->validFrom = $validFrom === null ? null : new DateTime($validFrom);
        } catch (Exception $e) {
            Logger::write($e->getMessage());
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @return DateTime|null
     */
    public function getValidUntil(): ?DateTime
    {
        return $this->validUntil;
    }

    /**
     * @param string|null $validUntil
     *
     * @throws Exception
     */
    protected function setValidUntil(?string $validUntil): void
    {
        try {
            $this->validUntil = $validUntil === null ? null : new DateTime($validUntil);
        } catch (Exception $e) {
            Logger::write($e->getMessage());
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param stdClass $guzzleClientResponse
     *
     * @throws Exception
     */
    protected function responseData(stdClass $guzzleClientResponse): void
    {
        if ($guzzleClientResponse->exists) {
            $this->setProductId($guzzleClientResponse->search_results->product_id);
            $this->setProductPrice($guzzleClientResponse->search_results->product_price);
            $this->setValidFrom($guzzleClientResponse->search_results->valid_from);
            $this->setValidUntil($guzzleClientResponse->search_results->valid_until);
        }
    }
}
