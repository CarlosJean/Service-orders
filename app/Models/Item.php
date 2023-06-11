<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name',
        'quantity',
        'price',
        'reference',
        'measurement_unit',
    ];

    public function orderItemDetail(){
        return $this->hasMany(OrderItemDetail::class);
    }

    public function inventories(){
        return $this->hasMany(Item::class);
    }
}
