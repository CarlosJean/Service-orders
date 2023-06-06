<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemsDetail extends Model
{
    use HasFactory;

    protected $quantity;    

    public function orderItem(){
        return $this->BelongsTo(OrderItem::class);
    }
    
    public function item(){
        return $this->belongsTo(Item::class);
    }
    
    protected $attributes = [
        'dispatched' => false
    ];
}
