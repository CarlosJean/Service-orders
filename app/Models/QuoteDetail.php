<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item',
        'reference',
        'quantity',
        'price',
        'supplier_id',
    ];

    public function quote(){
        return $this->belongsTo(Quote::class);
    }
}
