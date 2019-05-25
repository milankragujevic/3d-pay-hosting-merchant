<?php
declare(strict_types=1);

namespace App\Merchant;

use App\Order\Order;
use Slim\Container;

/**
 * Class MerchantConfiguration
 * @package App\Merchant
 */
abstract class MerchantConfiguration
{

    /**
     * @var string
     */
    protected $randomString;
    /**
     * @var Order
     */
    protected $order;
    /**
     * @var Container
     */
    protected $container;

    /**
     * MerchantConfiguration constructor.
     * @param Order $order
     * @param Container $container
     */
    public function __construct(Order $order, Container $container)
    {
        $this->order = $order;
        $this->container = $container;
        $this->randomString = $this->generateRandomString();
    }

    /**
     * @return string
     */
    private function generateRandomString(): string
    {
        $alphaLower = 'abcdefghijklmnopqrstuvwxyz';
        $alphaUpper = strtoupper($alphaLower);
        $specialChars = '!@#$%^&*()-_=+';
        return substr(str_shuffle("$alphaLower$alphaUpper$specialChars"), 0, 4);
    }

    /**
     * @return array
     */
    final public function fields(): array
    {
        return array_merge(
            $this->mandatoryInputFields(),
            $this->optionalInputFields(),
            $this->companyInputFields()
        );
    }

    /**
     * @return array
     */
    final public function mandatoryInputFields(): array
    {
        return [
            '3d_gateway_url' => $this->merchantUrl(),
            'clientid'       => $this->merchantId(),
            'storetype'      => $this->merchantPaymentModel(),
            'hash'           => $this->clientAuthenticationHash(),
            'trantype'       => $this->transactionType(),
            'amount'         => $this->order->getTransactionAmount(),
            'currency'       => $this->currency(),
            'oid'            => $this->order->getOrderNumber(),
            'okUrl'          => $this->okUrl(),
            'failUrl'        => $this->failUrl(),
            'lang'           => $this->language(),
            'rnd'            => $this->randomString
        ];
    }

    /**
     * @return string
     */
    abstract protected function merchantUrl(): string;

    /**
     * @return string
     */
    abstract protected function merchantId(): string;

    /**
     * @return string
     */
    abstract protected function merchantPaymentModel(): string;

    /**
     * @return string
     */
    private function clientAuthenticationHash(): string
    {
        return base64_encode(pack('H*', sha1(implode('', [
            $this->merchantId(),
            $this->order->getOrderNumber(),
            $this->order->getTransactionAmount(),
            $this->okUrl(),
            $this->failUrl(),
            $this->transactionType(),
            $this->randomString,
            $this->storeKey()
        ]))));
    }

    /**
     * @return string
     */
    abstract protected function okUrl(): string;

    /**
     * @return string
     */
    abstract protected function failUrl(): string;

    /**
     * @return string
     */
    abstract protected function transactionType(): string;

    /**
     * @return string
     */
    abstract protected function storeKey(): string;

    /**
     * @return int
     */
    abstract protected function currency(): int;

    /**
     * @return string
     */
    abstract protected function language(): string;

    /**
     * @return array
     */
    final public function optionalInputFields(): array
    {
        return [
            'refreshtime' => $this->refreshTime(),
            'encoding'    => $this->encoding()
        ];
    }

    /**
     * @return int
     */
    abstract protected function refreshTime(): int;

    /**
     * @return string
     */
    abstract protected function encoding(): string;

    /**
     * @return array
     */
    final public function companyInputFields(): array
    {
        return [
            'BillToCompany'    => $this->companyName(),
            'BillToName '      => $this->companyContactPerson(),
            'BillToStreet1'    => $this->companyAddress(),
            'BillToCity'       => $this->companyCity(),
            'BillToStateProv'  => $this->companyCountry(),
            'BillToPostalCode' => $this->companyPostalCode(),
            'BillToCountry'    => $this->companyCountry()
        ];
    }

    /**
     * @return string
     */
    abstract protected function companyName(): string;

    /**
     * @return string
     */
    abstract protected function companyContactPerson(): string;

    /**
     * @return string
     */
    abstract protected function companyAddress(): string;

    /**
     * @return string
     */
    abstract protected function companyCity(): string;

    /**
     * @return string
     */
    abstract protected function companyCountry(): string;

    /**
     * @return string
     */
    abstract protected function companyPostalCode(): string;
}
