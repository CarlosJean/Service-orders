<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'price',
        'quantity',
    ];

    public function items(){
        return $this->hasOne(Item::class, 'item_id');
    }
}
