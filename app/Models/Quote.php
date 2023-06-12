<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'created_by',
        'order_id',
        'total',
    ];

    public function details(){
        return $this->hasMany(QuoteDetail::class);
    }

    public function purchaseOrderDetail(){
        return $this->hasManyThrough(PurchaseOrderDetail::class, PurchaseOrder::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function orderItem(){
        return $this->hasOneThrough(OrderItem::class, Order::class,'id','service_order_id');
    }

}
