<?php
declare(strict_types=1);

namespace App\Merchant\Merchants;

use App\Constants;
use App\Merchant\MerchantConfiguration;
use App\Order\Order;
use Slim\Container;

/**
 * Class BelgradeMerchant
 * @package App\Merchant\Merchants
 */
final class BelgradeMerchant extends MerchantConfiguration
{

    /**
     * BelgradeMerchant constructor.
     * @param Order $order
     * @param Container $container
     */
    public function __construct(Order $order, Container $container)
    {
        parent::__construct($order, $container);
    }

    /**
     * @return string
     */
    protected function merchantUrl(): string
    {
        return 'https://vpos.aikbanka.rs/fim/est3Dgate';
    }

    /**
     * @return string
     */
    protected function merchantId(): string
    {
        return '510140012';
    }

    /**
     * @return string
     */
    protected function merchantPaymentModel(): string
    {
        return '3D_PAY_HOSTING';
    }

    /**
     * @return string
     */
    protected function transactionType(): string
    {
        return 'Auth';
    }

    /**
     * @return int
     */
    protected function currency(): int
    {
        return 941;
    }

    /**
     * @return string
     */
    protected function okUrl(): string
    {
        return Constants::BASE_URL . $this->container->router->relativePathFor('success');
    }

    /**
     * @return string
     */
    protected function failUrl(): string
    {
        return Constants::BASE_URL . $this->container->router->relativePathFor('failed');
    }

    /**
     * @return string
     */
    protected function language(): string
    {
        return 'en';
    }

    /**
     * @return string
     */
    protected function storeKey(): string
    {
        return 'SKEY0012';
    }

    /**
     * @return int
     */
    protected function refreshTime(): int
    {
        return 0;
    }

    /**
     * @return string
     */
    protected function encoding(): string
    {
        return 'utf-8';
    }

    /**
     * @return string
     */
    protected function companyName(): string
    {
        return 'APEX SOLUTION TECHNOLOGY DOO BEOGRAD';
    }

    /**
     * @return string
     */
    protected function companyContactPerson(): string
    {
        return 'Nataša Nešović';
    }

    /**
     * @return string
     */
    protected function companyAddress(): string
    {
        return 'Makenzija 24';
    }

    /**
     * @return string
     */
    protected function companyCity(): string
    {
        return 'Beograd';
    }

    /**
     * @return string
     */
    protected function companyCountry(): string
    {
        return 'Srbija';
    }

    /**
     * @return string
     */
    protected function companyPostalCode(): string
    {
        return '11050';
    }
}
