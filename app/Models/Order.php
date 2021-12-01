<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $invoice_number
 * @property int $purchaser_id
 * @property string $order_date
 */
class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'invoice_number', 'purchaser_id', 'order_date'];

}
