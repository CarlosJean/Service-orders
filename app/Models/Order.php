<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['requestor', 'number', 'issue', 'status'];

    public function orderItem(){
        return $this->hasOne(OrderItem::class, 'service_order_id');
    }
}
