<?php
declare(strict_types=1);

namespace App\Order;

/**
 * Class ItemProperties
 *
 * @package App\Order
 */
class ItemProperties
{

    /**
     * @var mixed
     */
    protected $items;

    /**
     * ItemProperties constructor.
     */
    public function __construct()
    {
        $this->items = unserialize((new Order)->getOrderItemsSerialized());
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
