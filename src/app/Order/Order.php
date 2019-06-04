<?php
declare(strict_types=1);

namespace App\Order;

use App\Assets;
use Exception;

/**
 * Class Order
 *
 * @package App\Order
 */
final class Order
{

    /**
     * Order constructor.
     */
    public function __construct()
    {
        if (!isset($_SESSION['order_id'])) {
            $_SESSION['order_id'] = $this->generateOrderNumber();
        }
    }

    /**
     * @return string
     */
    protected function generateOrderNumber(): string
    {
        $randomNumber = substr(str_replace(
            '.',
            '',
            strval(floatval(pi()) * floatval(rand(0, 99999)) * floatval(microtime()))
        ), 0, 6);
        return implode('', [$randomNumber, $randomNumber]);
    }

    /**
     * @param string $alias
     * @param int $productId
     *
     * @return void
     *
     * @throws Exception
     */
    public function addItemToCart(string $alias, int $productId): void
    {
        if (isset($_SESSION['orders'])) {
            $items = unserialize($_SESSION['orders']);
        }
        $items[] = new Item($alias, $productId);
        $_SESSION['orders'] = serialize($items);
    }

    /**
     * @param string $aliasNumber
     *
     * @return void
     */
    public function removeItemFromCart(string $aliasNumber): void
    {
        if (isset($_SESSION['orders'])) {
            $items = unserialize($_SESSION['orders']);
            $activeItems = array_filter($items, function (/** @var Item $record */ $record) use ($aliasNumber) {
                return $record->getAliasNumber() !== Assets::cleanUpAliasNumber($aliasNumber);
            });
            $_SESSION['orders'] = serialize($activeItems);
        }
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $_SESSION['order_id'];
    }

    /**
     * @return float
     */
    public function getTransactionAmount(): float
    {
        $transactionAmount = 0.00;
        $items = isset($_SESSION['orders']) ? unserialize($_SESSION['orders']) : [];
        array_walk($items, function (/** @var Item $item */ $item) use (&$transactionAmount) {
            $transactionAmount += $item->getProductPrice();
        });
        return $transactionAmount;
    }

    /**
     * @return array
     */
    public function getOrderItemsArray(): array
    {
        $items = isset($_SESSION['orders']) ? unserialize($_SESSION['orders']) : [];
        $orderedItems = array_map(function (/** @var Item $item */ $item) {
            return [
                'alias_number'   => $item->getAliasNumber(),
                'product_id'     => $item->getProductId(),
                'product_name'   => $item->getProductName(),
                'base_price'     => $item->getBasePrice(),
                'vat_amount'     => $item->getVatAmount(),
                'price_with_vat' => $item->getProductPrice()
            ];
        }, $items);
        return empty($orderedItems) ? [] : $orderedItems;
    }

    /**
     * @return string
     */
    public function getOrderItemsSerialized(): string
    {
        return $_SESSION['orders'];
    }

    /**
     * @return int
     */
    public function getNumberOfItems(): int
    {
        if (isset($_SESSION['orders'])) {
            $items = unserialize($_SESSION['orders']);
            return count($items);
        }
        return 0;
    }
}
