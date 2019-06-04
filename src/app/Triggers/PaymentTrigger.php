<?php
declare(strict_types=1);

namespace App\Triggers;

use App\DBManagers\ItemsManager;
use App\DBManagers\OrdersManager;
use App\Logger;
use App\Order\ItemProperties;
use App\Order\OrderProperties;
use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Connection;
use PDOException;
use RuntimeException;

/**
 * Class PaymentTrigger
 *
 * @package App\Triggers
 */
final class PaymentTrigger
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * PaymentTrigger constructor.
     */
    public function __construct()
    {
        $this->connection = DB::connection();
    }

    /**
     * @param OrderProperties $order
     * @param ItemProperties $items
     *
     * @throws Exception
     */
    public function beforePayment(OrderProperties $order, ItemProperties $items): void
    {
        $ordersManager = new OrdersManager($order, $this->connection);
        $itemsManager = new ItemsManager($items, $this->connection);
        try {
            $this->connection->beginTransaction();
            $ordersManager->store();
            $itemsManager->store();
            $this->connection->commit();
        } catch (Exception|PDOException $e) {
            try {
                $this->connection->rollBack();
            } catch (Exception $e) {
                Logger::write($e->getMessage());
                throw new RuntimeException($e->getMessage());
            }
            Logger::write($e->getMessage());
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param OrderProperties $orderDetails
     *
     * @throws Exception
     */
    public function afterPayment(OrderProperties $orderDetails): void
    {
        $ordersManager = new OrdersManager($orderDetails, $this->connection);
        try {
            $this->connection->beginTransaction();
            $ordersManager->update();
            $this->connection->commit();
        } catch (Exception|PDOException $e) {
            try {
                $this->connection->rollBack();
            } catch (Exception $e) {
                Logger::write($e->getMessage());
                throw new RuntimeException($e->getMessage());
            }
            Logger::write($e->getMessage());
            throw new RuntimeException($e->getMessage());
        }
    }
}
