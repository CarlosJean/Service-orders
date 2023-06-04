<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['service_order_id', 'requestor', 'status'];

    public function orderItemDetail(){
        return $this->hasMany(OrderItemsDetail::class);   
    }

    public function serviceOrder(){
        return $this->hasOne(Order::class);
    }
}
