<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'billing_date',
        'payment_method',
        'total'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
