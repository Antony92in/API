<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 *
 * @property string $full_name
 * @property string $address
 * @property double $amount
 * @property string $created_at
 */
class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

}
