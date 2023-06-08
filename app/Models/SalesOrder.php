<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the products for the sales order.
     */
    public function salesOrderProducts(): HasMany
    {
        return $this->hasMany(SalesOrderProduct::class, 'sales_order_id', 'id');
    }
}
