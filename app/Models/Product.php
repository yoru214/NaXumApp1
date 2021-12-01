<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $sku
 * @property string $name
 * @property float $price
 */
class Product extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'sku', 'name', 'price'];

}
