<?php
declare(strict_types=1);

namespace App\BusPlusService;

use App\Constants;
use Exception;
use GuzzleHttp\Client;
use InvalidArgumentException;
use RuntimeException;
use stdClass;

/**
 * Class Service
 *
 * @package App\BusPlusService
 */
abstract class Service
{

    /**
     * @var int
     */
    private $languageId = Constants::LANGUAGE;
    /**
     * @var int
     */
    private $merchantId = Constants::MERCHANT_ID;

    /**
     * Service constructor.
     *
     * @param string $uri
     * @param array $options
     */
    public function __construct(string $uri, array $options = [])
    {
        $this->makePostRequest($uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     *
     * @return void
     */
    private function makePostRequest(string $uri, array $options = []): void
    {
        try {
            $guzzleClient = new Client([
                'base_uri' => Constants::SERVICE_BASE_URL
            ]);
            $clientResponse = $guzzleClient->post($uri, $options);
            $responseContent = $clientResponse->getBody()->getContents();
            if ($clientResponse->getStatusCode() === 200) {
                if (empty($responseContent) && !is_string($responseContent)) {
                    throw new InvalidArgumentException('Response content is empty or it is not a string.');
                }
                $this->responseData(json_decode($responseContent));
            } else {
                throw new RuntimeException('HTTP response is not 200.');
            }
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param stdClass $responseData
     *
     * @return void
     */
    protected abstract function responseData(stdClass $responseData): void;

    /**
     * @param string $aliasNumber
     *
     * @return string
     */
    protected function cardInfoServiceURI(string $aliasNumber): string
    {
        return "card-info/$aliasNumber/$this->languageId/$this->merchantId";
    }

    /**
     * @param int $productId
     *
     * @return string
     */
    protected function productProfileURI(int $productId): string
    {
        return "product-profile/$productId/$this->languageId/$this->merchantId";
    }

    /**
     * @param string $aliasNumber
     * @param int $rechargeTypeId
     * @param int $zoneId
     *
     * @return string
     */
    protected function searchProductURI(string $aliasNumber, int $rechargeTypeId, int $zoneId): string
    {
        $cardInfo = new CardInfo($aliasNumber);
        return "search-product/{$cardInfo->getCardCategoryId()}/$rechargeTypeId/$zoneId/$this->merchantId";
    }

    /**
     * @return string
     */
    protected function sendOrdersURI(): string
    {
        return "web-setTopupBulk.php?merchant_id=$this->merchantId";
    }

    /**
     * @param string $orderNumber
     *
     * @return string
     */
    protected function invoiceURL(string $orderNumber): string
    {
        return "web-topup-confirmation/$orderNumber/$this->languageId/$this->merchantId";
    }
}