<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;
    protected $table = 'buyer';

    protected $fillable = [
        'document',
        'first_name',
        'second_name',
        'first_last_name',
        'second_last_name',
        'email',
        'phone',
    ];

    /**
     * Relación con las órdenes (order_details)
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'buyer_id');
    }
}