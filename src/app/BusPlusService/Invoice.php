<?php
declare(strict_types=1);

namespace App\BusPlusService;

use stdClass;

/**
 * Class Invoice
 *
 * @package App\BusPlusService
 */
class Invoice extends Service
{

    /**
     * @var string
     */
    protected $invoiceHTML;

    /**
     * Invoice constructor.
     *
     * @param string $orderNumber
     */
    public function __construct(string $orderNumber)
    {
        parent::__construct($this->invoiceURL($orderNumber));
    }

    /**
     * @return string|null
     */
    public function getInvoiceHTML(): ?string
    {
        return $this->invoiceHTML;
    }

    /**
     * @param stdClass $responseData
     *
     * @return void
     */
    protected function responseData(stdClass $responseData): void
    {
        $this->invoiceHTML = $responseData->content;
    }
}