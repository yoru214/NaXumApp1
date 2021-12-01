<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $order_id
 * @property int $product_id
 * @property int $qantity
 */
class OrderItem extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['order_id', 'product_id', 'qantity'];

}
