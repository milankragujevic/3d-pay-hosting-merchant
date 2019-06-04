<?php
declare(strict_types=1);

namespace App\DBManagers;

use App\Models\ItemsModel;
use App\Order\Item;
use App\Order\ItemProperties;
use App\Repositories\OrderRepository;
use Illuminate\Database\Connection;

/**
 * Class ItemsManager
 *
 * @package App\DBManagers
 */
final class ItemsManager
{

    /**
     * @var ItemProperties
     */
    protected $properties;
    /**
     * @var Connection
     */
    protected $connection;
    /**
     * @var ItemsModel
     */
    protected $model;

    /**
     * ItemsManager constructor.
     *
     * @param ItemProperties $properties
     * @param Connection $connection
     */
    public function __construct(ItemProperties $properties, Connection $connection)
    {
        $this->properties = $properties;
        $this->connection = $connection;
        $this->model = new ItemsModel();
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $repository = new OrderRepository();
        $content = array_map(function (/** @var Item $item */ $item) use ($repository) {
            return [
                'order_id'      => $repository->orderId($item->getOrderNumber()),
                'alias_number'  => $item->getAliasNumber(),
                'product_id'    => $item->getProductId(),
                'base_price'    => $item->getBasePrice(),
                'vat_amount'    => $item->getVATAmount(),
                'product_price' => $item->getProductPrice()
            ];
        }, $this->properties->getItems());
        $this->connection->table($this->model->getTable())->insert($content);
    }

    /**
     * @param string $orderNumber
     *
     * @return void
     */
    public function updateOnKKQueueField(string $orderNumber): void
    {
        $repository = new OrderRepository();
        $this->connection->table($this->model->getTable())
            ->where('order_id', '=', $repository->orderId($orderNumber))
            ->whereIn('alias_number', array_map(function (/** @var Item $item */ $item) use ($repository) {
                return $item->getAliasNumber();
            }, $this->properties->getItems()))->update([
                'is_on_kk_queue' => true
            ]);
    }
}
