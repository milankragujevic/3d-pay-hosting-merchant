<?php
declare(strict_types=1);

namespace App\BusPlusService;

use App\DBManagers\ItemsManager;
use App\Order\ItemProperties;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use stdClass;

/**
 * Class SendOrderToKK
 *
 * @package App\BusPlusService
 */
final class SendOrderToKK extends Service
{

    /**
     * @var string|null
     */
    protected $orderNumber;

    /**
     * SendOrderToKK constructor.
     *
     * @param string|null $orderNumber
     * @throws Exception
     */
    public function __construct(?string $orderNumber)
    {
        $this->orderNumber = $orderNumber;
        parent::__construct($this->sendOrdersURI(), [
            'body' => json_encode($this->loadOrderDetails())
        ]);
    }

    /**
     * @return array
     */
    protected function loadOrderDetails(): array
    {
        $orderRepository = new OrderRepository();
        $orderDetails = $orderRepository->orderDetails($this->orderNumber)->first();
        return [
            'order_number'       => strval($orderDetails->order_number),
            'transaction_amount' => floatval($orderDetails->transaction_amount),
            'items'              => array_map(function ($item) {
                return [
                    'alias_number'   => strval(substr($item->alias_number, 0, 10)),
                    'product_id'     => intval($item->product_id),
                    'base_price'     => floatval($item->base_price),
                    'vat_amount'     => floatval($item->vat_amount),
                    'price_with_vat' => floatval($item->product_price)
                ];
            }, iterator_to_array($orderDetails->items)),
            'updated_at'         => $orderDetails->updated_at,
            'created_at'         => $orderDetails->created_at
        ];
    }

    /**
     * @param stdClass $responseData
     */
    protected function responseData(stdClass $responseData): void
    {
        if (!$responseData->transaction_status->error_occured) {
            $itemsManager = new ItemsManager(new ItemProperties, DB::connection());
            $itemsManager->updateOnKKQueueField($this->orderNumber);
        }
    }
}
