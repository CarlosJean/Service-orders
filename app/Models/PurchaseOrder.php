<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quote_id',
        'number'
    ];

    public function detail(){
        return $this->hasMany(PurchaseOrderDetail::class);
    }
}
