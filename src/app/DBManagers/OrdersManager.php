<?php
declare(strict_types=1);

namespace App\DBManagers;

use App\Models\OrdersModel;
use App\Order\OrderProperties;
use Illuminate\Database\Connection;

/**
 * Class OrdersManager
 *
 * @package App\DBManagers
 */
final class OrdersManager
{

    /**
     * @var OrderProperties
     */
    protected $properties;
    /**
     * @var Connection
     */
    protected $connection;
    /**
     * @var OrdersModel
     */
    protected $model;

    /**
     * OrdersManager constructor.
     *
     * @param OrderProperties $properties
     * @param Connection $connection
     */
    public function __construct(OrderProperties $properties, Connection $connection)
    {
        $this->properties = $properties;
        $this->connection = $connection;
        $this->model = new OrdersModel();
    }

    /**
     * @return int
     */
    public function store(): int
    {
        $this->connection->table($this->model->getTable())->insert([
            'order_number'       => $this->properties->getOrderNumber(),
            'transaction_amount' => $this->properties->getTransactionAmount()
        ]);
        return intval($this->connection->getPdo()->lastInsertId());
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->connection->table($this->model->getTable())
            ->where('order_number', '=', $this->properties->getOrderNumber())
            ->update([
                'gateway_response' => $this->properties->gatewayResponse,
                'is_finished'      => $this->properties->isFinished,
                'is_charged'       => $this->properties->isCharged
            ]);
    }
}
