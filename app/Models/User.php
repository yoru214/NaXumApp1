<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property int $referred_by
 * @property string $enrolled_date
 */
class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'first_name', 'last_name', 'username', 'referred_by', 'enrolled_date'];

}
