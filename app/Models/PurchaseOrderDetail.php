<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'quantity',
        'price',
        'reference',
        'total_price',
        'supplier_id',
    ];

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    }
}