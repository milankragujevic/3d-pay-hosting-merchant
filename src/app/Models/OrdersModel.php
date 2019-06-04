<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OrdersModel
 * @package App\Models
 */
final class OrdersModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(ItemsModel::class, 'order_id', 'id');
    }
}
