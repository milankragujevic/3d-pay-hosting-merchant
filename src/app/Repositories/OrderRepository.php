<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\OrdersModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderRepository
 *
 * @package App\Repositories
 */
final class OrderRepository implements RepositoryInterface
{

    /**
     * @param string $orderNumber
     *
     * @return int
     */
    public function orderId(string $orderNumber): int
    {
        return $this->builder()->where('order_number', '=', $orderNumber)->get()->first()->id;
    }

    /**
     * @param array $relations
     *
     * @return Builder
     */
    public function builder(array $relations = []): Builder
    {
        return OrdersModel::with($relations);
    }

    /**
     * @param string $orderNumber
     *
     * @return Collection
     */
    public function orderDetails(string $orderNumber): Collection
    {
        return $this->builder(['items'])->where('is_charged', '=', true)
            ->where('order_number', '=', $orderNumber)->get();
    }
}
